<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Client;

use App\Service\API\IPLocateApiService;
use App\Service\Client\ClientCountryProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ClientCountryProviderTest extends TestCase
{
    private MockObject|IPLocateApiService $ipLocateApiService;
    private ClientCountryProvider $clientCountryProvider;

    protected function setUp(): void
    {
        $this->ipLocateApiService = $this->createMock(IPLocateApiService::class);
        $this->clientCountryProvider = new ClientCountryProvider($this->ipLocateApiService);
    }

    public function testGetCountryByIPIpV4NotExist(): void
    {
        $this->ipLocateApiService->expects(self::never())
            ->method('getUserInfoByIp');

        $this->assertNull($this->clientCountryProvider->getCountryByIP(null));
    }

    public function testGetCountryByIPCountryNotExist(): void
    {
        $ipV4 = '127.0.0.1';
        $this->ipLocateApiService->expects(self::once())
            ->method('getUserInfoByIp')
            ->with($ipV4)
            ->willReturn([]);

        $this->assertNull($this->clientCountryProvider->getCountryByIP($ipV4));
    }

    public function testGetCountryByIPApiResponsesError(): void
    {
        $ipV4 = '127.0.0.1';
        $this->ipLocateApiService->expects(self::once())
            ->method('getUserInfoByIp')
            ->with($ipV4)
            ->willThrowException(new \RuntimeException('Something went wrong'));

        $this->assertNull($this->clientCountryProvider->getCountryByIP($ipV4));
    }
}
