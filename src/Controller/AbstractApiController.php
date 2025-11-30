<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractApiController extends AbstractController
{
    protected function getPageQuery(Request $request, int $default = 1): int
    {
        return $request->query->getInt('page', $default);
    }

    protected function getLimitQuery(Request $request, int $default = 20): int
    {
        return $request->query->getInt('limit', $default);
    }
}
