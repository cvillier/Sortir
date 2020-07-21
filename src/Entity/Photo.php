<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 * @Vich\Uploadable()
 */
class Photo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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

    /**
     * @var User
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="photo")
     */
    private $user;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhotoName()
    {
        return $this->photoName;
    }

    public function setPhotoName(?string $photoName)
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
     * @return Photo
     */
    public function setPhotoFile(?File $photoFile): Photo
    {
        $this->photoFile = $photoFile;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Photo
     */
    public function setUser(User $user): Photo
    {
        $this->user = $user;
        return $this;
    }





}
