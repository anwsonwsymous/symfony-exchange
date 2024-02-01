<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class AbstractExchangeRateProvider
 * @package App\Service
 */
abstract class AbstractExchangeRateProvider implements ExchangeRateProviderInterface
{
    public function __construct(
        protected readonly HttpClientInterface $client
    )
    {
    }

    /**
     * @return array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getExchangeRates(): array
    {
        $response = $this->client->request('GET', $this->getApiUrl());

        if ($response->getStatusCode() === 200) {
            return $this->parseResponse($response->getContent());
        }

        return [];
    }

    abstract protected function getApiUrl(): string;

    abstract protected function parseResponse(string $response): array;
}
