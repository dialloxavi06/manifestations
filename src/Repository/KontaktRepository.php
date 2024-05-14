<?php

namespace App\Repository;

use App\Entity\Kontakt;
use App\Entity\PorteursDeProjet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PorteursDeProjet>
 *
 * @method PorteursDeProjet|null find($id, $lockMode = null, $lockVersion = null)
 * @method PorteursDeProjet|null findOneBy(array $criteria, array $orderBy = null)
 * @method PorteursDeProjet[]    findAll()
 * @method PorteursDeProjet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KontaktRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kontakt::class);
    }

    //    /**
    //     * @return PorteursDeProjet[] Returns an array of PorteursDeProjet objects
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

    //    public function findOneBySomeField($value): ?PorteursDeProjet
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
