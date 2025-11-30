<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\API;

use App\Service\API\IPLocateApiService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class IPLocateApiServiceTest extends TestCase
{
    private MockObject|HttpClientInterface $client;
    private IPLocateApiService $ipLocateApiService;

    protected function setUp(): void
    {
        $this->client = $this->createMock(HttpClientInterface::class);
        $this->ipLocateApiService = new IPLocateApiService($this->client);
    }

    public function testGetUserInfoByIp(): void
    {
        $ipv4 = '127.0.0.1';
        $response = $this->createMock(ResponseInterface::class);

        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'https://iplocate.io/api/lookup/127.0.0.1')
            ->willReturn($response);

        $response->expects($this->once())
            ->method('getContent')
            ->willReturn('{"country": "Ukraine", "ip": "127.0.0.1"}');

        $result = $this->ipLocateApiService->getUserInfoByIp($ipv4);
        $this->assertSame(['country' => 'Ukraine', 'ip' => '127.0.0.1'], $result);
    }
}
