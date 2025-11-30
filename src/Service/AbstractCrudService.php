<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\AbstractRepository;

abstract readonly class AbstractCrudService
{
    public function __construct(protected AbstractRepository $repository)
    {
    }

    public function save(object $entity, bool $flush): void
    {
        $this->repository->save($entity, $flush);
    }

    protected function remove(object $entity, bool $flush): void
    {
        $this->repository->remove($entity, $flush);
    }

    public function commit(): void
    {
        $this->repository->commit(true);
    }
}
