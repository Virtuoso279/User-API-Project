<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Client;

use App\Message\Client\ClientMessage;
use App\Service\Client\ClientMessageProducer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class ClientMessageProducerTest extends TestCase
{
    private MockObject|MessageBusInterface $messageBus;
    private ClientMessageProducer $producer;

    protected function setUp(): void
    {
        $this->messageBus = $this->createMock(MessageBusInterface::class);
        $this->producer = new ClientMessageProducer($this->messageBus);
    }

    public function testProduce(): void
    {
        $firstName = 'test name';
        $lastName = 'test last name';
        $phoneNumbers = ['0123456789', '1234567890'];
        $ipV4Address = '127.0.0.1';
        $country = 'Ukraine';

        $message = new ClientMessage($firstName, $lastName, $phoneNumbers, $ipV4Address, $country);

        $this->messageBus->expects($this->once())
            ->method('dispatch')
            ->with($message)
            ->willReturn(new Envelope($message));

        $this->producer->produce(
            $firstName,
            $lastName,
            $phoneNumbers,
            $ipV4Address,
            $country,
        );
    }
}
