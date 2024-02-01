<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Class CoinDeskExchangeRateProvider
 * @package App\Service
 */
class CoinDeskExchangeRateProvider extends AbstractExchangeRateProvider
{
    protected function getApiUrl(): string
    {
        return 'https://api.coindesk.com/v1/bpi/currentprice.json';
    }

    protected function parseResponse(string $response): array
    {
        $array = json_decode($response, true);

        return [
            'USD' => $array['bpi']['USD']['rate_float'],
            'GBP' => $array['bpi']['GBP']['rate_float'],
            'EUR' => $array['bpi']['EUR']['rate_float'],
        ];
    }

    public function getBaseCurrency(): string
    {
        return 'BTC';
    }

    public function getName(): string
    {
        return 'CoinDesk';
    }
}
