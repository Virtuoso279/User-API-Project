<?php

declare(strict_types=1);

namespace App\Controller\Client;

use App\Controller\AbstractApiController;
use App\Dto\Request\Client\ClientCreateRequestDto;
use App\Dto\Request\Client\ClientListQueryDto;
use App\Dto\Response\Client\ClientListResponseDto;
use App\Facade\Client\ClientCreateFacade;
use App\Facade\Client\ClientViewFacade;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/client', name: 'app_client_')]
#[OA\Tag(name: 'Client')]
class ClientController extends AbstractApiController
{
    #[Route(name: 'create', methods: ['POST'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new Model(type: ClientCreateRequestDto::class)
        )
    )]
    #[OA\Response(
        response: Response::HTTP_NO_CONTENT,
        description: 'Created successfully.',
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Bad request.',
    )]
    #[OA\Response(
        response: Response::HTTP_UNPROCESSABLE_ENTITY,
        description: 'Validation violations.',
    )]
    public function create(
        #[MapRequestPayload] ClientCreateRequestDto $clientCreateRequestDto,
        ClientCreateFacade $clientCreateFacade,
        Request $request,
    ): JsonResponse {
        $clientCreateFacade->processCreation($clientCreateRequestDto, $request->getClientIp());

        return $this->json(
            null,
            Response::HTTP_NO_CONTENT,
        );
    }

    #[Route(path: '/list', name: 'list_clients', methods: ['GET'])]
    #[OA\Parameter(
        name: 'page',
        description: 'Page number of the results to fetch',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'integer', default: 1),
    )]
    #[OA\Parameter(
        name: 'limit',
        description: 'Limit of results per page',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'integer', default: 20),
    )]
    #[OA\Parameter(
        name: 'lastName',
        description: 'Filter by lastName.',
        in: 'query',
        required: false,
    )]
    #[OA\Parameter(
        name: 'orderBy',
        description: 'Sort result by field. **Case sensitive**. Available options: `createdAt` or `fistName`',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string', default: 'sort'),
    )]
    #[OA\Parameter(
        name: 'orderDirection',
        description: 'Specifies sort direction. **Case sensitive**. Available options: `ASC` or `DESC`',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string', default: 'ASC'),
    )]
    #[OA\Response(
        response: Response::HTTP_UNPROCESSABLE_ENTITY,
        description: 'Validation violations.',
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'ok',
        content: new OA\JsonContent(
            ref: new Model(type: ClientListResponseDto::class)
        )
    )]
    public function listClients(
        ClientViewFacade $viewFacade,
        #[MapQueryString(validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY)]
        ClientListQueryDto $queryDto = new ClientListQueryDto(),
    ): JsonResponse {
        return $this->json($viewFacade->list(
            page: $queryDto->getPage(),
            limit: $queryDto->getLimit(),
            options: [
                'lastName' => $queryDto->getLastName(),
                'orderBy' => $queryDto->getOrderBy(),
                'orderDirection' => $queryDto->getOrderDirection(),
            ],
        ));
    }
}
