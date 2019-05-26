<?php

namespace App\Repository;

use App\Entity\ProductBundleItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductBundleItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductBundleItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductBundleItem[]    findAll()
 * @method ProductBundleItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductBundleItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductBundleItem::class);
    }

    public function findByProductBundleIdJoinedToProduct($productBundleId)
    {

        return $this->createQueryBuilder('pbi')
                ->select('p.id','p.title', 'p.price', 'p.currency')
                ->leftJoin('App\Entity\Product', 'p', 'WITH', 'p.id = pbi.productId')
                ->where('pbi.productBundleId = :productBundleIdParam')
                ->setParameter('productBundleIdParam', $productBundleId)
                ->getQuery()
                ->getResult();
    }


    // /**
    //  * @return ProductBundleItem[] Returns an array of ProductBundleItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductBundleItem
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
