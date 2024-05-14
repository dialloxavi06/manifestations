<?php

namespace App\Repository;

use App\Entity\TypeInstitution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeInstitution>
 *
 * @method TypeInstitution|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeInstitution|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeInstitution[]    findAll()
 * @method TypeInstitution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeInstitutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeInstitution::class);
    }

    //    /**
    //     * @return TypeInstitution[] Returns an array of TypeInstitution objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TypeInstitution
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
