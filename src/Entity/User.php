<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
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

    //comment for update
    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoName;

    /**
     * @var File|null
     * @Assert\Image(maxSize="4M")
     */
    private $photoFile;

    // CONSTRUCTOR

    public function __construct()
    {
        $this->sortieOrganise = new ArrayCollection();;
        $this->sortieUser = new ArrayCollection();;
    }

    // GETTERS ET SETTERS

    public function getId(): ?int
    {
        return $this->id;
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
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {

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

    /**
     * @return string|null
     */
    public function getPhotoName(): ?string
    {
        return $this->photoName;
    }

    /**
     * @param string|null $photoName
     * @return User
     */
    public function setPhotoName(?string $photoName): User
    {
        $this->photoName = $photoName;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    /**
     * @param File|null $photoFile
     * @return User
     */
    public function setPhotoFile(?File $photoFile): User
    {
        $this->photoFile = $photoFile;
        return $this;
    }


}
