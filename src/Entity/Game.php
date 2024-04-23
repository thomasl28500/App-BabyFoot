<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $idRouge = null;

    #[ORM\Column]
    private ?int $idBlue = null;

    #[ORM\Column]
    private ?int $idWinner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getIdRouge(): ?int
    {
        return $this->idRouge;
    }

    public function setIdRouge(int $idRouge): static
    {
        $this->idRouge = $idRouge;

        return $this;
    }

    public function getIdBlue(): ?int
    {
        return $this->idBlue;
    }

    public function setIdBlue(int $idBlue): static
    {
        $this->idBlue = $idBlue;

        return $this;
    }

    public function getIdWinner(): ?int
    {
        return $this->idWinner;
    }

    public function setIdWinner(int $idWinner): static
    {
        $this->idWinner = $idWinner;

        return $this;
    }
}
