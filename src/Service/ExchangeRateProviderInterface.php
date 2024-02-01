<?php

namespace App\Service;

/**
 * Interface ExchangeRateProviderInterface
 * @package App\Service
 */
interface ExchangeRateProviderInterface
{
    public function getExchangeRates(): array;

    public function getBaseCurrency(): string;

    public function getName(): string;
}
