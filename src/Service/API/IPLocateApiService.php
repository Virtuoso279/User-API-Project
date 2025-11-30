<?php

declare(strict_types=1);

namespace App\Service\API;

use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class IPLocateApiService
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function getUserInfoByIp(string $ipv4): array
    {
        $response = $this->client->request(
            method: 'GET',
            url: sprintf('https://iplocate.io/api/lookup/%s', $ipv4),
        );

        return json_decode($response->getContent(), true);
    }
}
