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
    private $sorties_no_sortie;


    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $participants_no_participant;


    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSortiesNoSortie()
    {
        return $this->sorties_no_sortie;
    }

    /**
     * @return mixed
     */
    public function getParticipantsNoParticipant()
    {
        return $this->participants_no_participant;
    }


}
