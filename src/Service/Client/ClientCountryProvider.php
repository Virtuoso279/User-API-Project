<?php

declare(strict_types=1);

namespace App\Service\Client;

use App\Service\API\IPLocateApiService;

readonly class ClientCountryProvider
{
    public function __construct(
        private IPLocateApiService $ipLocateApiService,
    ) {
    }

    public function getCountryByIP(?string $ipV4): ?string
    {
        if (is_null($ipV4)) {
            return null;
        }

        try {
            $response = $this->ipLocateApiService->getUserInfoByIp($ipV4);

            return $response['country'] ?? null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
