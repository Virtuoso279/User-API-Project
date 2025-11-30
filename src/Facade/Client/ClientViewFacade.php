<?php

declare(strict_types=1);

namespace App\Facade\Client;

use App\DataTransformer\Client\ClientResponseDtoTransformer;
use App\DataTransformer\PaginatedListDtoTransformer;
use App\DataTransformer\PaginationToPaginationResponseDtoTransformer;
use App\Facade\AbstractPaginatedListFacade;
use App\Service\Client\ClientReaderService;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;

readonly class ClientViewFacade extends AbstractPaginatedListFacade
{
    public function __construct(
        private ClientReaderService $clientReaderService,
        private ClientResponseDtoTransformer $itemDtoTransformer,
        PaginatorInterface $paginator,
        PaginatedListDtoTransformer $listDtoTransformer,
        PaginationToPaginationResponseDtoTransformer $paginationTransformer,
    ) {
        parent::__construct($paginator, $listDtoTransformer, $paginationTransformer);
    }

    protected function entityListQueryBuilder(array $options = []): QueryBuilder
    {
        return $this->clientReaderService->clientsQueryBuilder(options: $options);
    }

    protected function transformListItems(array $items): array
    {
        return $this->itemDtoTransformer->transformList($items);
    }
}
