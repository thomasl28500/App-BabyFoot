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
            ->where('m.dateGame < :now') // Filtre pour obtenir les matchs avec une date de jeu future
            ->setParameter('now', new \DateTime()) // Utilise la date actuelle comme référence
            ->orderBy('m.dateGame', 'DESC') // Trie par date_game en ordre décroissant
            ->setMaxResults(1) // Limite à un seul résultat (le plus récent)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findNextMatch(): ? Game
    {
        return $this->createQueryBuilder('m')
            ->where('m.dateGame > :now') // Filtre pour obtenir les matchs avec une date de jeu future
            ->setParameter('now', new \DateTime()) // Utilise la date actuelle comme référence
            ->orderBy('m.dateGame', 'ASC') // Trie par date de jeu en ordre croissant
            ->setMaxResults(1) // Limite à un seul résultat (le prochain match)
            ->getQuery()
            ->getOneOrNullResult();
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
