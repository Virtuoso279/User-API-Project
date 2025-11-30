<?php

declare(strict_types=1);

namespace App\Dto\Request\Client;

use Symfony\Component\Validator\Constraints as Assert;

class ClientCreateRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        private string $firstName,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        private string $lastName,

        #[Assert\Type('array')]
        private ?array $phoneNumbers,
    ) {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNumbers(): ?array
    {
        return $this->phoneNumbers;
    }

    public function setPhoneNumbers(?array $phoneNumbers): static
    {
        $this->phoneNumbers = $phoneNumbers;

        return $this;
    }
}
