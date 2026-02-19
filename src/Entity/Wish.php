<?php

namespace App\Entity;

use App\Repository\WishRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WishRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Wish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 250)]
    #[Assert\NotBlank(message: 'Le nom de votre souhait est obligatoire')]
    #[Assert\Length(min:3, max: 30, minMessage: 'Votre souhait doit faire au moins {{ limit }} caractères',
        maxMessage: 'Votre souhait ne doit pas dépasser 30 caractères')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'La description de votre souhait est obligatoire')]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isPublished = true;

    #[ORM\Column]
    private ?\DateTime $dateCreated = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateUpdated = null;

    #[ORM\ManyToOne(inversedBy: 'wishes', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'wishes', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $username = null;

    //ajout de 2 fonctions pour mettre à jour la date à la date du jour
    #[ORM\PrePersist]
    public function onPersist(): void {
        $this->dateCreated = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function onUpdate(): void {
        $this->dateUpdated = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title ? ucfirst($title) : $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getDateCreated(): ?\DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?\DateTime $dateCreated): static
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateUpdated(): ?\DateTime
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(\DateTime $dateUpdated): static
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getUsername(): ?User
    {
        return $this->username;
    }

    public function setUsername(?User $username): static
    {
        $this->username = $username;

        return $this;
    }
}
