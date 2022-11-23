<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Photo;

/**
 * @extends ServiceEntityRepository<Photo>
 *
 * @method Photo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photo[]    findAll()
 * @method Photo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRepository extends Repository
{
    static function getEntityClassName(): string
    {
        return Photo::class;
    }
}
