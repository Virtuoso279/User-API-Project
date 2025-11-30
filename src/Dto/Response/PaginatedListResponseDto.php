<?php

declare(strict_types=1);

namespace App\Dto\Response;

class PaginatedListResponseDto implements ListResponseWithPaginationInterface
{
    public function __construct(
        protected PaginationResponseDto $paginationInfo,
        protected array $items,
    ) {
    }

    public function getPaginationInfo(): PaginationResponseDto
    {
        return $this->paginationInfo;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
