<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;



/**
 * @extends ServiceEntityRepository<Project> 
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Project::class);
    }

    //    /**
    //     * @return Project[] Returns an array of Project objects
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

    //    public function findOneBySomeField($value): ?Project
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //  

    /**
     * Récupère le contenu traduit d'un champ pour une langue donnée.
     *
     * @param int    $id   L'ID de l'entité Project
     * @param string $field Le champ à traduire
     * @param string $locale La langue pour laquelle récupérer la traduction
     * 
     * @return string|null Le contenu traduit du champ, null si non trouvé
     */
    public function findAllOrderedByIdAsc()
    {
        return $this->createQueryBuilder('et')
            ->orderBy('et.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function paginateProjects(int $page, int $limit): PaginationInterface
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
    /**
     * Ajoute un contact à un projet.
     *
     * @param int $projectId L'ID du projet
     * @param int $kontaktId L'ID du contact
     */

    public function addKontaktByProjectId(int $projectId, int $kontaktId): void
    {
        $project = $this->find($projectId);
        $kontakt = $this->_em->getReference('App\Entity\Kontakt', $kontaktId);

        $project->addKontakt($kontakt);
        $this->_em->flush();
    }
}
