<?php

namespace App\Entity;

use App\Repository\PlayerTeamsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerTeamsRepository::class)]
class PlayerTeams
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idPlayer = null;

    #[ORM\Column]
    private ?int $idTeam = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPlayer(): ?int
    {
        return $this->idPlayer;
    }

    public function setIdPlayer(int $idPlayer): static
    {
        $this->idPlayer = $idPlayer;

        return $this;
    }

    public function getIdTeam(): ?int
    {
        return $this->idTeam;
    }

    public function setIdTeam(int $idTeam): static
    {
        $this->idTeam = $idTeam;

        return $this;
    }
}
