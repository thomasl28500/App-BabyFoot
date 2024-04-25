<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Player;
use Doctrine\ORM\Mapping\Id;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function classementTeam(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.victory', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findTeamsWithSinglePlayer(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->join('t.teamCompositions', 'tc')
            ->groupBy('t.id, t.name')
            ->having('COUNT(tc.idPlayer) = 1')
            ->getQuery()
            ->getResult();
    }

    public function findTeamsByUser(Player $user): array
    {
        $query = $this->createQueryBuilder('t')
            ->select('t')
            ->join('t.teamCompositions', 'tc')
            ->join('tc.idPlayer', 'p')
            ->where('p.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery();

        return $query->getResult();
    }
}
