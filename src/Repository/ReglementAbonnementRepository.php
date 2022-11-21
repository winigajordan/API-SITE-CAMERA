<?php

namespace App\Repository;

use App\Entity\ReglementAbonnement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReglementAbonnement>
 *
 * @method ReglementAbonnement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReglementAbonnement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReglementAbonnement[]    findAll()
 * @method ReglementAbonnement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReglementAbonnementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReglementAbonnement::class);
    }

    public function save(ReglementAbonnement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReglementAbonnement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReglementAbonnement[] Returns an array of ReglementAbonnement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReglementAbonnement
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
