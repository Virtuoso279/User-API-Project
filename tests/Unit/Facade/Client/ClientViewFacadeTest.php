<?php

declare(strict_types=1);

namespace App\Tests\Unit\Facade\Client;

use App\DataTransformer\Client\ClientResponseDtoTransformer;
use App\DataTransformer\PaginatedListDtoTransformer;
use App\DataTransformer\PaginationToPaginationResponseDtoTransformer;
use App\Dto\Response\PaginatedListResponseDto;
use App\Dto\Response\PaginationResponseDto;
use App\Facade\Client\ClientViewFacade;
use App\Service\Client\ClientReaderService;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ClientViewFacadeTest extends TestCase
{
    private MockObject|PaginatorInterface $paginator;
    private MockObject|PaginatedListDtoTransformer $listDtoTransformer;
    private MockObject|PaginationToPaginationResponseDtoTransformer $paginationTransformer;
    private MockObject|ClientReaderService $clientReaderService;
    private MockObject|ClientResponseDtoTransformer $itemDtoTransformer;

    private ClientViewFacade $clientViewFacade;

    protected function setUp(): void
    {
        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->listDtoTransformer = $this->createMock(PaginatedListDtoTransformer::class);
        $this->paginationTransformer = $this->createMock(PaginationToPaginationResponseDtoTransformer::class);
        $this->clientReaderService = $this->createMock(ClientReaderService::class);
        $this->itemDtoTransformer = $this->createMock(ClientResponseDtoTransformer::class);

        $this->clientViewFacade = new ClientViewFacade(
            $this->clientReaderService,
            $this->itemDtoTransformer,
            $this->paginator,
            $this->listDtoTransformer,
            $this->paginationTransformer,
        );
    }

    public function testList(): void
    {
        $qb = $this->createMock(QueryBuilder::class);
        $query = $this->createMock(Query::class);

        $qb->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);

        $this->clientReaderService->expects($this->once())
            ->method('clientsQueryBuilder')
            ->with(['firstName' => 'test1'])
            ->willReturn($qb);

        $paginationInterface = $this->createMock(PaginationInterface::class);
        $this->paginator->expects($this->once())
            ->method('paginate')
            ->with($query, 1, 20, ['firstName' => 'test1'])
            ->willReturn($paginationInterface);

        $paginationResponseDto = $this->createMock(PaginationResponseDto::class);
        $this->paginationTransformer->expects($this->once())
            ->method('transform')
            ->with($paginationInterface)
            ->willReturn($paginationResponseDto);

        $paginationInterface->expects($this->once())
            ->method('getItems')
            ->willReturn(['item1', 'item2']);

        $this->itemDtoTransformer->expects($this->once())
            ->method('transformList')
            ->with(['item1', 'item2'])
            ->willReturn(['itemTransformed1', 'itemTransformed2']);

        $result = $this->createMock(PaginatedListResponseDto::class);
        $this->listDtoTransformer->expects($this->once())
            ->method('transform')
            ->with($paginationResponseDto, ['itemTransformed1', 'itemTransformed2'])
            ->willReturn($result);

        $this->assertSame($result, $this->clientViewFacade->list(1, 20, ['firstName' => 'test1']));
    }
}
