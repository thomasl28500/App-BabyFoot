<?php

namespace App\Repository;

use App\Entity\NickName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NickName>
 *
 * @method NickName|null find($id, $lockMode = null, $lockVersion = null)
 * @method NickName|null findOneBy(array $criteria, array $orderBy = null)
 * @method NickName[]    findAll()
 * @method NickName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NickNameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NickName::class);
    }

//    /**
//     * @return NickName[] Returns an array of NickName objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NickName
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
