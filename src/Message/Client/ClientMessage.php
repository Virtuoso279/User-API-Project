<?php

declare(strict_types=1);

namespace App\Message\Client;

readonly class ClientMessage
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private ?array $phoneNumbers,
        private string $ipV4,
        private string $country,
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

    public function getPhoneNumbers(): ?array
    {
        return $this->phoneNumbers;
    }

    public function getIpV4(): string
    {
        return $this->ipV4;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
