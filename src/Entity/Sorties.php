<?php

namespace App\Entity;

use App\Repository\SortiesRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=SortiesRepository::class)
 */
class Sorties
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
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datedebut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecloture;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbinscriptionsmax;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptioninfos;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $motifAnnulation;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $urlPhoto;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archivee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieux",inversedBy="sortie")
     */
    private $noLieu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etats",inversedBy="sorties")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campus",inversedBy="sorties")
     */
    private $campus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="sortieOrganise")
     */
    private $organisateur;

    // OneToMany qui va crée la table de pivot avec le OneToMany situé dans User.php
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscriptions",mappedBy="sortie")
     */
    private $sortieUser;

    // CONSTRUCTEUR

    public function __construct()
    {
        $this->sortieUser = new ArrayCollection();
    }

    //GETTERS AND SETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNoLieu()
    {
        return $this->noLieu;
    }

    /**
     * @param mixed $noLieu
     */
    public function setNoLieu($noLieu): void
    {
        $this->noLieu = $noLieu;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getCampus()
    {
        return $this->campus;
    }

    /**
     * @param mixed $campus
     */
    public function setCampus($campus): void
    {
        $this->campus = $campus;
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

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;
        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;
        return $this;
    }

    public function getDatecloture(): ?\DateTimeInterface
    {
        return $this->datecloture;
    }

    public function setDatecloture(\DateTimeInterface $datecloture): self
    {
        $this->datecloture = $datecloture;
        return $this;
    }

    public function getNbinscriptionsmax(): ?int
    {
        return $this->nbinscriptionsmax;
    }

    public function setNbinscriptionsmax(int $nbinscriptionsmax): self
    {
        $this->nbinscriptionsmax = $nbinscriptionsmax;
        return $this;
    }

    public function getDescriptioninfos(): ?string
    {
        return $this->descriptioninfos;
    }

    public function setDescriptioninfos(?string $descriptioninfos): self
    {
        $this->descriptioninfos = $descriptioninfos;
        return $this;
    }


    public function getMotifAnnulation(): ?string
    {
        return $this->motifAnnulation;
    }


    public function setMotifAnnulation(?string $motifAnnulation): self
    {
        $this->motifAnnulation = $motifAnnulation;
        return $this;
    }


    public function getUrlPhoto(): ?string
    {
        return $this->urlPhoto;
    }

    public function setUrlPhoto(?string $urlPhoto): self
    {
        $this->urlPhoto = $urlPhoto;
        return $this;
    }

    public function getArchivee(): ?bool
    {
        return $this->archivee;
    }

    public function setArchivee(bool $archivee): self
    {
        $this->archivee = $archivee;
        return $this;
    }

    public function getOrganisateur(): ?User
    {
        return $this->organisateur;
    }

    public function setOrganisateur(User $organisateur): self
    {
        $this->organisateur = $organisateur;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSortieUser(): Collection
    {
        return $this->sortieUser;
    }

    /**
     * @param ArrayCollection $sortieUser
     */
    public function setSortieUser(Collection $sortieUser): void
    {
        $this->sortieUser = $sortieUser;
    }


}
