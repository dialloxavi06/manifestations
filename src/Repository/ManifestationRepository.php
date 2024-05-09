<?php

namespace App\Repository;

use App\Entity\Manifestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Manifestation>
 *
 * @method Manifestation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manifestation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manifestation[]    findAll()
 * @method Manifestation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManifestationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Manifestation::class);
    }

    //    /**
    //     * @return Manifestation[] Returns an array of Manifestation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Manifestation
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function paginateManifestations(int $page, int $limit): PaginationInterface
    {
        $query = $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC')
            ->getQuery();

        return $this->paginator->paginate(
            $query,
            $page,
            $limit
        );
    }
}
