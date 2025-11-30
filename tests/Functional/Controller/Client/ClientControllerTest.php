<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Client;

use App\Dto\Response\Client\ClientResponseDto;
use App\Dto\Response\PaginatedListResponseDto;
use App\Dto\Response\PaginationResponseDto;
use App\Facade\Client\ClientCreateFacade;
use App\Facade\Client\ClientViewFacade;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ClientControllerTest extends WebTestCase
{
    private function mockClientCreateFacade(): void
    {
        /** @var ClientCreateFacade&MockObject $mock */
        $mock = $this->createMock(ClientCreateFacade::class);

        $mock->expects(self::once())
            ->method('processCreation');

        static::getContainer()->set(ClientCreateFacade::class, $mock);
    }

    private function mockClientViewFacade(PaginatedListResponseDto $returnData): void
    {
        /** @var ClientViewFacade&MockObject $mock */
        $mock = $this->createMock(ClientViewFacade::class);

        $mock->expects(self::once())
            ->method('list')
            ->with(
                self::anything(), // page
                self::anything(), // limit
                self::arrayHasKey('lastName')
            )
            ->willReturn($returnData);

        static::getContainer()->set(ClientViewFacade::class, $mock);

    }

    public function testCreateClientSuccessfully(): void
    {
        $client = static::createClient();

        $this->mockClientCreateFacade();

        $payload = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'phoneNumber' => '+380501234567',
        ];

        $client->request(
            method: 'POST',
            uri: '/api/client',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload, JSON_THROW_ON_ERROR)
        );

        self::assertSame(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
        self::assertSame('', $client->getResponse()->getContent());
    }

    public function testCreateClientValidationError(): void
    {
        $client = static::createClient();
        $invalidPayload = [
            'firstName' => 'John',
        ];

        $client->request(
            method: 'POST',
            uri: '/api/client',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($invalidPayload, JSON_THROW_ON_ERROR)
        );

        self::assertSame(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $client->getResponse()->getStatusCode(),
            $client->getResponse()->getContent()
        );
    }

    public function testListClientsReturnsData(): void
    {
        $client = static::createClient();

        $dto = new PaginatedListResponseDto(
            new PaginationResponseDto(7, 1, 20),
            [
                new ClientResponseDto(
                    'John',
                    'Smith',
                    'Ukraine',
                    ['123456789'],
                ),
            ],
        );

        $this->mockClientViewFacade($dto);

        $client->request(
            method: 'GET',
            uri: '/api/client/list',
            parameters: [
                'page' => 1,
                'limit' => 20,
                'lastName' => 'Doe',
                'orderBy' => 'createdAt',
                'orderDirection' => 'ASC',
            ]
        );

        self::assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $data = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $expectedArray = [
            'paginationInfo' => [
                'totalPageCount' => 1,
                'isFirstPage' => true,
                'isLastPage' => true,
                'totalItemCount' => 7,
                'currentPageNumber' => 1,
                'itemNumberPerPage' => 20,
            ],
            'items' => [
                [
                    'firstName' => 'John',
                    'lastName' => 'Smith',
                    'country' => 'Ukraine',
                    'phoneNumbers' => ['123456789'],
                ],
            ],
        ];

        self::assertSame($expectedArray, $data);
    }

    public function testListClientsValidationError(): void
    {
        $client = static::createClient();

        $client->request(
            method: 'GET',
            uri: '/api/client/list',
            parameters: [
                'page' => 0,
            ]
        );

        self::assertSame(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $client->getResponse()->getStatusCode(),
            $client->getResponse()->getContent()
        );
    }
}
