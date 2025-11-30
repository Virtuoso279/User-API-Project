<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractRepository extends ServiceEntityRepository
{
    public function save(object $entity, bool $flush): void
    {
        $this->getEntityManager()->persist($entity);

        $this->commit($flush);
    }

    public function remove(object $entity, bool $flush): void
    {
        $this->getEntityManager()->remove($entity);

        $this->commit($flush);
    }

    public function commit(bool $flush): void
    {
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
