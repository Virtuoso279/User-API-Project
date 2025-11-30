<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Client;
use App\Trait\Repository\QueryBuilderRepositoryTrait;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<Client>
 */
class ClientRepository extends AbstractRepository
{
    use QueryBuilderRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function clientsQueryBuilder(string $alias = 'c', array $options = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder($alias)->select($alias);

        $this->applyQueryBuilderFilters(
            queryBuilder: $queryBuilder,
            options: $this->formatOptions($options),
            filterConditions: [
                'lastName' => sprintf('%s.lastName LIKE :lastName', $alias),
            ],
        );

        if (isset($options['orderBy']) && $options['orderBy']) {
            $queryBuilder->orderBy(
                sprintf('%s.%s', $alias, $options['orderBy']),
                $options['orderDirection'] ?? 'ASC',
            );
        }

        return $queryBuilder;
    }

    private function formatOptions(array $options): array
    {
        if (isset($options['lastName'])) {
            $options['lastName'] = '%' . $options['lastName'] . '%';
        }

        return $options;
    }
}
