<?php

declare(strict_types=1);

namespace App\Dto\Request\Client;

use Symfony\Component\Validator\Constraints as Assert;

class ClientListQueryDto
{
    public function __construct(
        #[Assert\Length(max: 255)]
        private ?string $lastName = null,

        #[Assert\Choice(choices: ['createdAt', 'firstName'])]
        private ?string $orderBy = 'sort',

        #[Assert\Choice(choices: ['ASC', 'DESC'])]
        private ?string $orderDirection = 'ASC',

        #[Assert\GreaterThan(0)]
        private int $page = 1,

        #[Assert\GreaterThan(0)]
        private int $limit = 20,
    ) {
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function setOrderBy(?string $orderBy): static
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function setOrderDirection(?string $orderDirection): static
    {
        $this->orderDirection = $orderDirection;

        return $this;
    }

    public function getOrderDirection(): ?string
    {
        return $this->orderDirection;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): static
    {
        $this->page = max(1, $page);

        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): static
    {
        $this->limit = max(1, $limit);

        return $this;
    }
}
