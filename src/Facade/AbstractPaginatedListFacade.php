<?php

declare(strict_types=1);

namespace App\Facade;

use App\DataTransformer\PaginatedListDtoTransformer;
use App\DataTransformer\PaginationToPaginationResponseDtoTransformer;
use App\Dto\Response\PaginatedListResponseDto;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

abstract readonly class AbstractPaginatedListFacade
{
    public function __construct(
        protected PaginatorInterface $paginator,
        protected PaginatedListDtoTransformer $listDtoTransformer,
        protected PaginationToPaginationResponseDtoTransformer $paginationTransformer,
    ) {
    }

    abstract protected function entityListQueryBuilder(array $options = []): QueryBuilder;

    abstract protected function transformListItems(array $items): array;

    public function list(int $page, int $limit, array $options = []): PaginatedListResponseDto
    {
        $paginatedEntities = $this->paginate($page, $limit, $options);

        return $this->listDtoTransformer->transform(
            $this->paginationTransformer->transform($paginatedEntities),
            $this->transformListItems($paginatedEntities->getItems()),
        );
    }

    protected function paginate(int $page, int $limit, array $options = []): PaginationInterface
    {
        return $this->paginator->paginate(
            target: $this->entityListQueryBuilder($options)->getQuery(),
            page: $page,
            limit: $limit,
            options: $options,
        );
    }
}
