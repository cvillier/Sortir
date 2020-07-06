<?php

namespace App\Entity;

use App\Repository\InscriptionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionsRepository::class)
 */
class Inscriptions
{

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_inscription;


    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $no_sortie;


    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $no_participant;




    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    public function getNoSortie(): ?int
    {
        return $this->no_sortie;
    }

    public function getNoParticipant(): ?int
    {
        return $this->no_participant;
    }
}
