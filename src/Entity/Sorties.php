<?php

namespace App\Entity;

use App\Repository\SortiesRepository;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $urlPhoto;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieux",inversedBy="sorties")
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

    /* /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     * @ORM\JoinTable(name="sortie_user")

    private $sortieUser;
    */

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscriptions",mappedBy="sortie")
     */
    private $sortieUser;


   /* public function __construct()
    {
        $this->sortieUser = new ArrayCollection();
    }
*/

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
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @return mixed
     */
    public function getCampus()
    {
        return $this->campus;
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

    public function getUrlPhoto(): ?string
    {
        return $this->urlPhoto;
    }

    public function setUrlPhoto(?string $urlPhoto): self
    {
        $this->urlPhoto = $urlPhoto;

        return $this;
    }

    public function getOrganisateur(): ?int
    {
        return $this->organisateur;
    }

    public function setOrganisateur(int $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }


}
