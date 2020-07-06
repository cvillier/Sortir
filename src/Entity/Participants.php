<?php

namespace App\Entity;

use App\Repository\ParticipantsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipantsRepository::class)
 */
class Participants
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $no_participant;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $mot_de_passe;

    /**
     * @ORM\Column(type="binary")
     */
    private $administrateur;

    /**
     * @ORM\Column(type="binary")
     */
    private $actif;

    /**
     * @ORM\Column(type="integer")
     */
    private $no_campus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoParticipant(): ?int
    {
        return $this->no_participant;
    }

    public function setNoParticipant(int $no_participant): self
    {
        $this->no_participant = $no_participant;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $mot_de_passe): self
    {
        $this->mot_de_passe = $mot_de_passe;

        return $this;
    }

    public function getAdministrateur()
    {
        return $this->administrateur;
    }

    public function setAdministrateur($administrateur): self
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    public function getActif()
    {
        return $this->actif;
    }

    public function setActif($actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getNoCampus(): ?int
    {
        return $this->no_campus;
    }

    public function setNoCampus(int $no_campus): self
    {
        $this->no_campus = $no_campus;

        return $this;
    }
}
