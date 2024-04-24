<?php

namespace App\Repository;

use App\Entity\PaysTiers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaysTiers>
 *
 * @method PaysTiers|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaysTiers|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaysTiers[]    findAll()
 * @method PaysTiers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaysTiersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaysTiers::class);
    }

    //    /**
    //     * @return PaysTiers[] Returns an array of PaysTiers objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PaysTiers
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
