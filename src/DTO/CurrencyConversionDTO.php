<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CurrencyConversionDTO
 * @package App\DTO
 */
class CurrencyConversionDTO
{
    #[Assert\NotBlank(message: "Please enter an amount.")]
    #[Assert\Type(
        type: 'numeric',
        message: 'The amount must be a number.'
    )]
    #[Assert\Positive(message: "The amount must be a positive number (greater than 0).")]
    public ?float $amount;

    // Custom validation for currency (Symfony's currency constraint doesn't work on crypto currencies)
    #[Assert\NotBlank(message: "Please select the source currency.")]
    public ?string $fromCurrency;

    #[Assert\NotBlank(message: "Please select the target currency.")]
    public ?string $toCurrency;

    public function __construct(float $amount = null, string $fromCurrency = null, string $toCurrency = null)
    {
        $this->amount = $amount;
        $this->fromCurrency = $fromCurrency;
        $this->toCurrency = $toCurrency;
    }
}
