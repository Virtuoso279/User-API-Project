<?php

declare(strict_types=1);

namespace App\DataTransformer\Client;

use App\DataTransformer\AbstractResponseListTransformer;
use App\Dto\Response\Client\ClientResponseDto;
use App\Entity\Client;

class ClientResponseDtoTransformer extends AbstractResponseListTransformer
{
    public function transform(Client $client): ClientResponseDto
    {
        return new ClientResponseDto(
            firstName: $client->getFirstName(),
            lastName: $client->getLastName(),
            country: $client->getCountry(),
            phoneNumbers: $client->getPhoneNumbers(),
        );
    }
}
