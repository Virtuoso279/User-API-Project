<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Client;

use App\Repository\ClientRepository;
use App\Service\Client\ClientReaderService;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ClientReaderServiceTest extends TestCase
{
    private MockObject|ClientRepository $clientRepository;
    private ClientReaderService $clientReaderService;

    protected function setUp(): void
    {
        $this->clientRepository = $this->createMock(ClientRepository::class);
        $this->clientReaderService = new ClientReaderService($this->clientRepository);
    }

    public function testClientsQueryBuilder(): void
    {
        $options = ['lastName' => 'test1'];
        $qb = $this->createMock(QueryBuilder::class);

        $this->clientRepository->expects($this->once())
            ->method('clientsQueryBuilder')
            ->with('c', $options)
            ->willReturn($qb);

        $result = $this->clientReaderService->clientsQueryBuilder($options);
        $this->assertSame($qb, $result);
    }
}
