<?php

namespace App\Entity;

use App\Repository\TeamCompositionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamCompositionRepository::class)]
class TeamComposition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'teamCompositions')]
    private ?Player $idPlayer = null;

    #[ORM\ManyToOne(inversedBy: 'teamCompositions')]
    private ?Team $idTeam = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPlayer(): ?Player
    {
        return $this->idPlayer;
    }

    public function setIdPlayer(?Player $idPlayer): static
    {
        $this->idPlayer = $idPlayer;

        return $this;
    }

    public function getIdTeam(): ?Team
    {
        return $this->idTeam;
    }

    public function setIdTeam(?Team $idTeam): static
    {
        $this->idTeam = $idTeam;

        return $this;
    }
}
