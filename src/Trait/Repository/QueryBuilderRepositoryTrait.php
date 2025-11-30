<?php

declare(strict_types=1);

namespace App\Trait\Repository;

use Doctrine\ORM\QueryBuilder;

trait QueryBuilderRepositoryTrait
{
    private function applyQueryBuilderFilters(
        QueryBuilder $queryBuilder,
        array $options,
        array $filterConditions,
    ): void {
        foreach ($filterConditions as $key => $condition) {
            if (isset($options[$key])) {
                $queryBuilder->andWhere($condition)
                    ->setParameter($key, $options[$key]);
            }
        }
    }

    private function applyQueryBuilderSort(QueryBuilder $queryBuilder, array $options, array $orderColumns): void
    {
        $orderDirection = strtoupper($options['orderDirection'] ?? 'ASC') === 'DESC' ? 'DESC' : 'ASC';

        if (isset($options['orderBy'], $orderColumns[$options['orderBy']])) {
            $queryBuilder->orderBy(
                $orderColumns[$options['orderBy']],
                $orderDirection,
            );
        }
    }
}
