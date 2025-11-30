<?php

declare(strict_types=1);

namespace App\Dto\Response\Client;

readonly class ClientResponseDto
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $country,
        private ?array $phoneNumbers,
    ) {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPhoneNumbers(): ?array
    {
        return $this->phoneNumbers;
    }
}
