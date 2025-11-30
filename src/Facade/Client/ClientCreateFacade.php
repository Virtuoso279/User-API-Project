<?php

declare(strict_types=1);

namespace App\Facade\Client;

use App\Dto\Request\Client\ClientCreateRequestDto;
use App\Service\Client\ClientCountryProvider;
use App\Service\Client\ClientMessageProducer;

readonly class ClientCreateFacade
{
    public function __construct(
        private ClientCountryProvider $countryProvider,
        private ClientMessageProducer $messageProducer,
    ) {
    }

    public function processCreation(ClientCreateRequestDto $requestDto, ?string $clientIpV4): void
    {
        $this->messageProducer->produce(
            firstName: $requestDto->getFirstName(),
            lastName: $requestDto->getLastName(),
            phoneNumbers: $requestDto->getPhoneNumbers(),
            ipV4: $clientIpV4 ?? 'undefined',
            country: $this->countryProvider->getCountryByIP(ipV4: $clientIpV4) ?? 'undefined',
        );
    }
}
