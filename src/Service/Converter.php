<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CurrencyConversionDTO;
use App\Repository\UsdRateRepository;
use Exception;

/**
 * Class Converter
 * @package App\Service
 */
class Converter
{
    public function __construct(private readonly UsdRateRepository $rateRepository)
    {
    }

    /**
     * @throws Exception
     */
    public function convert(CurrencyConversionDTO $conversionDTO): float
    {
        $source = $this->rateRepository->getByCurrency($conversionDTO->fromCurrency);
        $target = $this->rateRepository->getByCurrency($conversionDTO->toCurrency);

        return ($target->getRate() / $source->getRate()) * $conversionDTO->amount;
    }
}
