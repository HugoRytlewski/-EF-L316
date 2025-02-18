<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeRepository::class)]
#[ORM\Table(name: '`like`')]
class Like
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    private ?subject $idSubject = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    private ?user $idUser = null;

    #[ORM\Column]
    private ?bool $IsLiked = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSubject(): ?subject
    {
        return $this->idSubject;
    }

    public function setIdSubject(?subject $idSubject): static
    {
        $this->idSubject = $idSubject;

        return $this;
    }

    public function getIdUser(): ?user
    {
        return $this->idUser;
    }

    public function setIdUser(?user $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function isLiked(): ?bool
    {
        return $this->IsLiked;
    }

    public function setIsLiked(bool $IsLiked): static
    {
        $this->IsLiked = $IsLiked;

        return $this;
    }
}
