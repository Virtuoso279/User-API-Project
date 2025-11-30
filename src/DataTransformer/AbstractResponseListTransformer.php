<?php

declare(strict_types=1);

namespace App\DataTransformer;

abstract class AbstractResponseListTransformer
{
    public function transformList(array $entityList): array
    {
        return array_map(function (object $entity) {
            return $this->transform($entity);
        }, $entityList);
    }
}
