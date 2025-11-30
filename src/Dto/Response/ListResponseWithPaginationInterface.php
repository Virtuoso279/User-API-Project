<?php

declare(strict_types=1);

namespace App\Dto\Response;

interface ListResponseWithPaginationInterface
{
    public function getPaginationInfo(): PaginationResponseDto;

    public function getItems(): array;
}
