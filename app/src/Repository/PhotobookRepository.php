<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Photobook;

/**
 * @extends ServiceEntityRepository<Photobook>
 *
 * @method Photobook|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photobook|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photobook[]    findAll()
 * @method Photobook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotobookRepository extends Repository
{
    static function getEntityClassName(): string
    {
        return Photobook::class;
    }
}
