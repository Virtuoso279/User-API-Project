<?php

declare(strict_types=1);

namespace App\Dto\Response;

readonly class PaginationResponseDto
{
    private int $totalPageCount;
    private bool $isFirstPage;
    private bool $isLastPage;

    public function __construct(
        private int $totalItemCount,
        private int $currentPageNumber,
        private int $itemNumberPerPage,
    ) {
        $this->totalPageCount = (int) ceil($this->totalItemCount / $this->itemNumberPerPage);
        $this->isFirstPage = $this->currentPageNumber === 1;
        $this->isLastPage = $this->currentPageNumber === $this->totalPageCount;
    }

    public function getTotalPageCount(): int
    {
        return $this->totalPageCount;
    }

    public function getIsFirstPage(): bool
    {
        return $this->isFirstPage;
    }

    public function getIsLastPage(): bool
    {
        return $this->isLastPage;
    }

    public function getTotalItemCount(): int
    {
        return $this->totalItemCount;
    }

    public function getCurrentPageNumber(): int
    {
        return $this->currentPageNumber;
    }

    public function getItemNumberPerPage(): int
    {
        return $this->itemNumberPerPage;
    }
}
