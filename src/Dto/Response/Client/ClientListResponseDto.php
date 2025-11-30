<?php

declare(strict_types=1);

namespace App\Dto\Response\Client;

use App\Dto\Response\PaginatedListResponseDto;
use App\Dto\Response\PaginationResponseDto;

class ClientListResponseDto extends PaginatedListResponseDto
{
    /** @param ClientResponseDto[] $items */
    public function __construct(
        protected PaginationResponseDto $paginationInfo,
        protected array $items,
    ) {
        parent::__construct($paginationInfo, $items);
    }
}
