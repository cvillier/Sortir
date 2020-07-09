<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"pseudo"}, message="There is already an account with this pseudo")
 */
class User implements UserInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $actif;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campus;

    /**
     * @ORM\OneToMany(targetEntity=Sorties::class, mappedBy="organisateur")
     */
    private $sortieOrganise;

    // OneToMany qui va crée la table de pivot avec le OneToMany situé dans Sorties.php
    /**
     * @ORM\OneToMany(targetEntity=Inscriptions::class,mappedBy="user")
     */
    private $sortieUser;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureFileName;

    // CONSTRUCTOR

    public function __construct()
    {
//        $this->roles = ['ROLE_USER'];
        $this->sortieOrganise = new ArrayCollection();;
        $this->sortieUser = new ArrayCollection();;
    }


    // GETTERS ET SETTERS



    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->pseudo;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
//        // guarantee every user at least has ROLE_USER
//        $roles[] = ['ROLE_USER', 'ROLE_ADMIN', 'ROLE_ORGANISATEUR', 'ROLE_PARTICIPANT'];

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSortieOrganise(): Collection
    {
        return $this->sortieOrganise;
    }

    /**
     * @param ArrayCollection $sortieOrganise
     */
    public function setSortieOrganise(Collection $sortieOrganise): void
    {
        $this->sortieOrganise = $sortieOrganise;
    }

    /**
     * @return Collection
     */
    public function getSortieUser(): Collection
    {
        return $this->sortieUser;
    }

    /**
     * @param Collection $sortieUser
     */
    public function setSortieUser(Collection $sortieUser): void
    {
        $this->sortieUser = $sortieUser;
    }

    public function getPictureFileName(): ?string
    {
        return $this->pictureFileName;
    }

    public function setPictureFileName(?string $pictureFileName): self
    {
        $this->pictureFileName = $pictureFileName;

        return $this;
    }

}
