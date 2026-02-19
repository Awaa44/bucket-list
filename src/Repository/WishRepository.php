<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wish>
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    public function getDetailWish(int $id): ?Wish {
        return $this->createQueryBuilder('w')
            ->addSelect('category', 'username')
            ->leftJoin('w.category', 'category')
            ->leftJoin('w.username', 'username')
            ->andWhere('w.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getListWishes(): array {
        return $this->createQueryBuilder('w')
            ->addSelect('category', 'username')
            ->leftJoin('w.category', 'category')
            ->leftJoin('w.username', 'username')
            ->getQuery()
            ->getResult();
    }



    //    /**
    //     * @return Wish[] Returns an array of Wish objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Wish
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
