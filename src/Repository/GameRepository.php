<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findMostRecentMatch(): ? Game
    { 
        return $this->createQueryBuilder('m')
            ->where('m.dateGame < :now AND m.isFinish = true')
            ->setParameter('now', new \DateTime())
            ->orderBy('m.dateGame', 'DESC') // Trie par date en ordre décroissant
            ->setMaxResults(1) // Uun seul résultat (le plus récent)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findNextMatch(): ? Game
    {
        return $this->createQueryBuilder('m')
            ->where('m.dateGame > :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('m.dateGame', 'ASC') // Trie par date en ordre croissant
            ->setMaxResults(1) // Un seul résultat (NEXT)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function historicalMatch(): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.dateGame <= :now AND m.isFinish = true') // Matchs jusqu'à date actuelle
            ->setParameter('now', new \DateTime()) // date actuelle
            ->orderBy('m.dateGame', 'DESC') // Trie par date de jeu en ordre décroissant
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return Game[] Returns an array of Game objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Game
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
