<?php

namespace App\Repository;

use App\Entity\AbonnementInscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AbonnementInscription>
 *
 * @method AbonnementInscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbonnementInscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbonnementInscription[]    findAll()
 * @method AbonnementInscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonnementInscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbonnementInscription::class);
    }

    public function save(AbonnementInscription $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AbonnementInscription $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AbonnementInscription[] Returns an array of AbonnementInscription objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AbonnementInscription
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
