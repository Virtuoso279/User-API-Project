<?php

declare (strict_types = 1);

namespace App\Service\Client;

use App\Message\Client\ClientMessage;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class ClientMessageProducer
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    public function produce(
        string $firstName,
        string $lastName,
        ?array $phoneNumbers,
        string $ipV4,
        string $country,
    ): void {
        $this->messageBus->dispatch(
            new ClientMessage(
                firstName: $firstName,
                lastName: $lastName,
                phoneNumbers: $phoneNumbers,
                ipV4: $ipV4,
                country: $country
            ),
        );
    }
}
