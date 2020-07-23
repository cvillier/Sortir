<?php

namespace App\Entity;

use App\Repository\LieuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LieuxRepository::class)
 */
class Lieux
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom_lieu;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $rue;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Villes",inversedBy="lieux")
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sorties",mappedBy="noLieu");
     */
    private $sortie;

// CONSTRUCTOR

    public function __construct()
    {
        $this->sortie = new ArrayCollection();
    }

// GETTERS ET SETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLieu(): ?string
    {
        return $this->nom_lieu;
    }

    public function setNomLieu(string $nom_lieu): self
    {
        $this->nom_lieu = $nom_lieu;
        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;
        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function setVille($ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return ArrayCollection
     */
    public function getSortie(): ArrayCollection
    {
        return $this->sortie;
    }

    /**
     * @param ArrayCollection $sortie
     */
    public function setSortie(ArrayCollection $sortie): void
    {
        $this->sortie = $sortie;
    }
}
