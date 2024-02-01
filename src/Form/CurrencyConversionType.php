<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\CurrencyConversionDTO;
use App\Repository\UsdRateRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CurrencyConversionType
 * @package App\Form
 */
class CurrencyConversionType extends AbstractType
{
    public function __construct(private readonly UsdRateRepository $rateRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currencies = $this->rateRepository->getAllCurrencies();

        $builder
            ->add('amount', NumberType::class, [
                'label' => 'Amount',
                'required' => true,
                'scale' => 2,
            ])
            ->add('fromCurrency', ChoiceType::class, [
                'choices' => $currencies,
                'label' => 'From Currency',
                'required' => true,
            ])
            ->add('toCurrency', ChoiceType::class, [
                'choices' => $currencies,
                'label' => 'To Currency',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CurrencyConversionDTO::class,
            'currency_choices' => [],
        ]);
    }
}
