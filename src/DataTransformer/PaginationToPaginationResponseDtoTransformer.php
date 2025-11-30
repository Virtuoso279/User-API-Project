<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\Dto\Response\PaginationResponseDto;
use Knp\Component\Pager\Pagination\PaginationInterface;

class PaginationToPaginationResponseDtoTransformer
{
    public function transform(PaginationInterface $pagination): PaginationResponseDto
    {
        return new PaginationResponseDto(
            $pagination->getTotalItemCount(),
            $pagination->getCurrentPageNumber(),
            $pagination->getItemNumberPerPage(),
        );
    }
}
