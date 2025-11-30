<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\Dto\Response\PaginatedListResponseDto;
use App\Dto\Response\PaginationResponseDto;

class PaginatedListDtoTransformer
{
    public function transform(PaginationResponseDto $paginationInfo, array $items): PaginatedListResponseDto
    {
        return new PaginatedListResponseDto(
            paginationInfo: $paginationInfo,
            items: $items,
        );
    }
}
