<?php

declare (strict_types = 1);

namespace App\Service\Client;

use App\Repository\ClientRepository;
use Doctrine\ORM\QueryBuilder;

readonly class ClientReaderService
{
    public function __construct(
        private ClientRepository $clientRepository,
    ) {
    }

    public function clientsQueryBuilder(array $options = []): QueryBuilder
    {
        return $this->clientRepository->clientsQueryBuilder(options: $options);
    }
}
