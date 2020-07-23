<?php

namespace App\Entity;

use App\Repository\VillesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VillesRepository::class)
 */
class Villes
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
    private $nom_ville;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code_postal;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lieux", mappedBy="ville")
     */
    private $lieux;

    // CONSTRUCTOR
    public function __construct()
    {
        $this->lieux = new ArrayCollection();
    }

    // GETTERS ET SETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVille(): ?string
    {
        return $this->nom_ville;
    }

    public function setNomVille(string $nom_ville): self
    {
        $this->nom_ville = $nom_ville;
        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getLieux(): ArrayCollection
    {
        return $this->lieux;
    }

    /**
     * @param ArrayCollection $lieux
     */
    public function setLieux(ArrayCollection $lieux): void
    {
        $this->lieux = $lieux;
    }

}
