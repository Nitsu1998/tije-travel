<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Products>
 *
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function findProductsBySupplierId($supplierId = null)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        // Check if the supplierId parameter is provided and valid
        if ($supplierId !== null && is_numeric($supplierId)) {
            $queryBuilder
                ->andWhere('p.supplier_id = :supplier_id')
                ->setParameter('supplier_id', $supplierId);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
