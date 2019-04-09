<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
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
    private $Title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Up;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Down;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Voter", mappedBy="Vote")
     */
    private $voters;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->voters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getUp(): ?int
    {
        return $this->Up;
    }

    public function setUp(?int $Up): self
    {
        $this->Up = $Up;

        return $this;
    }

    public function getDown(): ?int
    {
        return $this->Down;
    }

    public function setDown(?int $Down): self
    {
        $this->Down = $Down;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @return Collection|Voter[]
     */
    public function getVoters(): Collection
    {
        return $this->voters;
    }

    public function addVoter(Voter $voter): self
    {
        if (!$this->voters->contains($voter)) {
            $this->voters[] = $voter;
            $voter->addVote($this);
        }

        return $this;
    }

    public function removeVoter(Voter $voter): self
    {
        if ($this->voters->contains($voter)) {
            $this->voters->removeElement($voter);
            $voter->removeVote($this);
        }

        return $this;
    }
}
