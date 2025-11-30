<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\Client\ClientMessage;
use App\Service\Client\ClientCreationService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ClientMessageHandler
{
    public function __construct(
        private ClientCreationService $clientCreationService,
    ) {
    }

    public function __invoke(ClientMessage $message): void
    {
        $this->clientCreationService->create(
            firstName: $message->getFirstName(),
            lastName: $message->getLastName(),
            phoneNumbers: $message->getPhoneNumbers(),
            ipV4: $message->getIpv4(),
            country: $message->getCountry(),
        );
    }
}
