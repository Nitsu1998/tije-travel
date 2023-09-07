<?php

namespace App\Repository;

use App\Entity\ProductMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductMedia>
 *
 * @method ProductMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductMedia[]    findAll()
 * @method ProductMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductMediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductMedia::class);
    }
}
