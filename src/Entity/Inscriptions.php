<?php

namespace App\Entity;

use App\Repository\SortieUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SortieUserRepository::class)
 */
class Inscriptions
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Sorties", inversedBy="sortieUser")
     * @ORM\JoinColumn(name="sortie_id", referencedColumnName="id", nullable=false)
     */
    private $sortie;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sortieUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getSortie(): ?Sorties
    {
        return $this->sortie;
    }

    public function setSortie(Sorties $sortie): self
    {
        $this->sortie = $sortie;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
