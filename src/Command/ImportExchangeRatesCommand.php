<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\ExchangeRate;
use App\Repository\ExchangeRateRepository;
use App\Repository\UsdRateRepository;
use App\Service\AbstractExchangeRateProvider;
use App\Service\ExchangeRateProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ImportExchangeRatesCommand
 * @package App\Command
 */
class ImportExchangeRatesCommand extends Command
{
    protected static $defaultName = 'app:import-exchange-rates';
    private iterable $providers;

    private ExchangeRateRepository $exchangeRateRepository;

    private UsdRateRepository $usdRateRepository; // Our internal

    public function __construct(
        iterable               $providers,
        ExchangeRateRepository $exchangeRateRepository,
        UsdRateRepository      $usdRateRepository,
    )
    {
        parent::__construct();
        $this->providers = $providers;
        $this->exchangeRateRepository = $exchangeRateRepository;
        $this->usdRateRepository = $usdRateRepository;
    }

    protected function configure()
    {
        $this->setDescription('Updates exchange rates from all providers.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->importFromProviders($io);
        $this->normalizeRates($io);

        return Command::SUCCESS;
    }

    private function importFromProviders(SymfonyStyle $io): void
    {
        /** @var ExchangeRateProviderInterface $provider */
        foreach ($this->providers as $provider) {
            $rates = $provider->getExchangeRates();

            foreach ($rates as $currency => $rate) {
                $this->exchangeRateRepository->storeExchangeRate(
                    $provider->getBaseCurrency(),
                    $currency,
                    $rate,
                    $provider->getName(),
                );
            }

            $io->success('Updated exchange rates from ' . $provider->getName());
        }
    }

    private function normalizeRates(SymfonyStyle $io): void
    {
        $usdBasedRates = $this->exchangeRateRepository->getByTarget('USD');

        /** @var ExchangeRate $usdBasedRate */
        foreach ($usdBasedRates as $usdBasedRate) {
            $rate = 1 / $usdBasedRate->getRate();
            $this->usdRateRepository->storeRate($usdBasedRate->getSource(), $rate);

            $exchangeRates = $this->exchangeRateRepository->getByProvider($usdBasedRate->getProvider());

            /** @var ExchangeRate $exchangeRate */
            foreach ($exchangeRates as $exchangeRate) {
                $this->usdRateRepository->storeRate($exchangeRate->getTarget(), $exchangeRate->getRate() * $rate);
            }

            $io->success('Normalized rates provided by ' . $usdBasedRate->getProvider());
        }
    }
}
