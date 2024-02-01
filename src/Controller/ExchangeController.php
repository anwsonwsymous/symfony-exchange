<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CurrencyConversionDTO;
use App\Form\CurrencyConversionType;
use App\Repository\UsdRateRepository;
use App\Service\Converter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ExchangeController
 * @package App\Controller
 */
class ExchangeController extends AbstractController
{
    public function __construct(
        private readonly Converter         $exchange,
        private readonly FlashBagInterface $flashBag,
        private readonly UsdRateRepository $rateRepository,
    )
    {
    }

    #[Route('/', name: 'exchange_form')]
    public function index(): Response
    {
        $form = $this->createForm(
            CurrencyConversionType::class,
            new CurrencyConversionDTO(),
            ['currency_choices' => $this->rateRepository->getAllCurrencies()]
        );

        return $this->render('conversion/convert.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/exchange', name: 'exchange_process')]
    public function convert(Request $request): Response
    {
        $form = $this->createForm(CurrencyConversionType::class);
        $form->handleRequest($request);
        $result = null;

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CurrencyConversionDTO $conversionDto */
            $conversionDto = $form->getData();
            $convertedAmount = $this->exchange->convert($conversionDto);

            $this->flashBag->add('success', sprintf(
                "%.8f %s is equivalent to %.8f %s",
                $conversionDto->amount,
                $conversionDto->fromCurrency,
                $convertedAmount,
                $conversionDto->toCurrency,
            ));
        } else {
            foreach ($form->getErrors(true) as $error) {
                $this->flashBag->add('danger', $error->getMessage());
            }
        }

        return $this->redirectToRoute('exchange_form');
    }
}
