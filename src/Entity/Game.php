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

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Team $teamBlue = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Team $teamRed = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Team $teamWin = null;

    #[ORM\Column]
    private ?int $teamBlueScore = null;

    #[ORM\Column]
    private ?int $teamRedScore = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateGame = null;

    #[ORM\Column]
    private ?bool $isFinish = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamBlue(): ?Team
    {
        return $this->teamBlue;
    }

    public function setTeamBlue(?Team $teamBlue): static
    {
        $this->teamBlue = $teamBlue;

        return $this;
    }

    public function getTeamRed(): ?Team
    {
        return $this->teamRed;
    }

    public function setTeamRed(?Team $teamRed): static
    {
        $this->teamRed = $teamRed;

        return $this;
    }

    public function getTeamWin(): ?Team
    {
        return $this->teamWin;
    }

    public function setTeamWin(?Team $teamWin): static
    {
        $this->teamWin = $teamWin;

        return $this;
    }

    public function getTeamBlueScore(): ?int
    {
        return $this->teamBlueScore;
    }

    public function setTeamBlueScore(int $teamBlueScore): static
    {
        $this->teamBlueScore = $teamBlueScore;

        return $this;
    }

    public function getTeamRedScore(): ?int
    {
        return $this->teamRedScore;
    }

    public function setTeamRedScore(int $teamRedScore): static
    {
        $this->teamRedScore = $teamRedScore;

        return $this;
    }

    public function getDateGame(): ?\DateTimeInterface
    {
        return $this->dateGame;
    }

    public function setDateGame(\DateTimeInterface $dateGame): static
    {
        $this->dateGame = $dateGame;

        return $this;
    }

    public function isFinish(): ?bool
    {
        return $this->isFinish;
    }

    public function setFinish(bool $isFinish): static
    {
        $this->isFinish = $isFinish;

        return $this;
    }
}
