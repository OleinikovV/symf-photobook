<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\IEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, static::getEntityClassName());
    }

    abstract static function getEntityClassName(): string;

    public function getEmptyEntity(): IEntity
    {
        $className = static::getEntityClassName();
        return new $className();
    }

    public function save(IEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(IEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAll(int $limit = null): array
    {
        return $this->createQueryBuilder('p')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findById($id): ?IEntity
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
