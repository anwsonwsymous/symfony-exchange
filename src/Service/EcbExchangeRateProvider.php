<?php

namespace App\Service;

/**
 * Class EcbCurrencyRateProvider
 * @package App\Service
 */
class EcbExchangeRateProvider extends AbstractExchangeRateProvider
{
    protected function getApiUrl(): string
    {
        return 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
    }

    protected function parseResponse(string $response): array
    {
        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $data = json_decode($json, true);

        $rates = [];
        foreach ($data['Cube']['Cube']['Cube'] as $item) {
            $currency = $item['@attributes']['currency'];
            $rate = (float) $item['@attributes']['rate'];
            $rates[$currency] = $rate;
        }

        return $rates;
    }

    public function getBaseCurrency(): string
    {
        return 'EUR';
    }

    public function getName(): string
    {
        return 'Ecb';
    }
}
