<?php

declare(strict_types=1);

namespace App\Service\Client;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Service\AbstractCrudService;

readonly class ClientCreationService extends AbstractCrudService
{
    public function __construct(ClientRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(
        string $firstName,
        string $lastName,
        ?array $phoneNumbers,
        string $ipV4,
        string $country,
        bool $commit = true,
    ): Client {
        $client = (new Client())
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setPhoneNumbers($phoneNumbers)
            ->setIpV4($ipV4)
            ->setCountry($country);

        $this->save($client, $commit);

        return $client;
    }
}
