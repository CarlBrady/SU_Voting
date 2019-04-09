<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoterRepository")
 */
class Voter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Username;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Vote", inversedBy="voters")
     */
    private $Vote;

    public function __construct()
    {
        $this->Vote = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getVote(): Collection
    {
        return $this->Vote;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->Vote->contains($vote)) {
            $this->Vote[] = $vote;
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->Vote->contains($vote)) {
            $this->Vote->removeElement($vote);
        }

        return $this;
    }
}
