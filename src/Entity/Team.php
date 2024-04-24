<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, Game>
     */
    #[ORM\OneToMany(targetEntity: Game::class, mappedBy: 'teamBlue')]
    private Collection $games;

    /**
     * @var Collection<int, TeamComposition>
     */
    #[ORM\OneToMany(targetEntity: TeamComposition::class, mappedBy: 'idTeam')]
    private Collection $teamCompositions;

    #[ORM\Column]
    private ?int $victory = null;

    #[ORM\Column]
    private ?int $defeat = null;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->teamCompositions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setTeamBlue($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getTeamBlue() === $this) {
                $game->setTeamBlue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TeamComposition>
     */
    public function getTeamCompositions(): Collection
    {
        return $this->teamCompositions;
    }

    public function addTeamComposition(TeamComposition $teamComposition): static
    {
        if (!$this->teamCompositions->contains($teamComposition)) {
            $this->teamCompositions->add($teamComposition);
            $teamComposition->setIdTeam($this);
        }

        return $this;
    }

    public function removeTeamComposition(TeamComposition $teamComposition): static
    {
        if ($this->teamCompositions->removeElement($teamComposition)) {
            // set the owning side to null (unless already changed)
            if ($teamComposition->getIdTeam() === $this) {
                $teamComposition->setIdTeam(null);
            }
        }

        return $this;
    }

    public function getVictory(): ?int
    {
        return $this->victory;
    }

    public function setVictory(int $victory): static
    {
        $this->victory = $victory;

        return $this;
    }

    public function getDefeat(): ?int
    {
        return $this->defeat;
    }

    public function setDefeat(int $defeat): static
    {
        $this->defeat = $defeat;

        return $this;
    }
}
