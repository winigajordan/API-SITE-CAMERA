<?php

namespace App\Repository;

use App\Entity\ReglementPackage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReglementPackage>
 *
 * @method ReglementPackage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReglementPackage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReglementPackage[]    findAll()
 * @method ReglementPackage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReglementPackageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReglementPackage::class);
    }

    public function save(ReglementPackage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReglementPackage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReglementPackage[] Returns an array of ReglementPackage objects
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

//    public function findOneBySomeField($value): ?ReglementPackage
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
