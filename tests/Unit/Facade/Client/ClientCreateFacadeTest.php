<?php

declare(strict_types=1);

namespace App\Tests\Unit\Facade\Client;

use App\Dto\Request\Client\ClientCreateRequestDto;
use App\Facade\Client\ClientCreateFacade;
use App\Service\Client\ClientCountryProvider;
use App\Service\Client\ClientMessageProducer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ClientCreateFacadeTest extends TestCase
{
    private MockObject|ClientCountryProvider $clientCountryProvider;
    private MockObject|ClientMessageProducer $clientMessageProducer;
    private ClientCreateFacade $clientCreateFacade;

    protected function setUp(): void
    {
        $this->clientCountryProvider = $this->createMock(ClientCountryProvider::class);
        $this->clientMessageProducer = $this->createMock(ClientMessageProducer::class);
        $this->clientCreateFacade = new ClientCreateFacade(
            $this->clientCountryProvider,
            $this->clientMessageProducer,
        );
    }

    public function testProcessCreation(): void
    {
        $requestDto = $this->createMock(ClientCreateRequestDto::class);
        $requestDto->expects(self::once())->method('getFirstName')->willReturn('firstName');
        $requestDto->expects(self::once())->method('getLastName')->willReturn('lastName');
        $requestDto->expects(self::once())->method('getPhoneNumbers')->willReturn(['1234567489']);

        $this->clientCountryProvider->expects(self::once())
            ->method('getCountryByIP')
            ->with('127.0.0.1')
            ->willReturn('Ukraine');

        $this->clientMessageProducer->expects(self::once())
            ->method('produce')
            ->with('firstName', 'lastName', ['1234567489'], '127.0.0.1', 'Ukraine');

        $this->clientCreateFacade->processCreation($requestDto, '127.0.0.1');
    }
}
