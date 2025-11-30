<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Client;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Service\Client\ClientCreationService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ClientCreationServiceTest extends TestCase
{
    private MockObject|ClientRepository $clientRepository;
    private ClientCreationService $clientCreationService;

    protected function setUp(): void
    {
        $this->clientRepository = $this->createMock(ClientRepository::class);
        $this->clientCreationService = new ClientCreationService($this->clientRepository);
    }

    public function testCreate(): void
    {
        $firstName = 'test name';
        $lastName = 'test last name';
        $phoneNumbers = ['0123456789', '1234567890'];
        $ipV4Address = '127.0.0.1';
        $country = 'Ukraine';

        $this->clientRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Client::class));

        $result = $this->clientCreationService->create(
            $firstName,
            $lastName,
            $phoneNumbers,
            $ipV4Address,
            $country,
        );

        $this->assertSame($firstName, $result->getFirstName());
        $this->assertSame($lastName, $result->getLastName());
        $this->assertSame($phoneNumbers, $result->getPhoneNumbers());
        $this->assertSame($country, $result->getCountry());
        $this->assertSame($ipV4Address, $result->getIpV4());
    }
}
