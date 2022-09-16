<?php

namespace App\Entity;

use App\Repository\ActualiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActualiteRepository::class)]
class Actualite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'actualites')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    #[ORM\JoinColumn(nullable: false)]
    private ?chocolaterie $chocolaterie = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_actu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_actu_alt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $crated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChocolaterie(): ?chocolaterie
    {
        return $this->chocolaterie;
    }

    public function setChocolaterie(?chocolaterie $chocolaterie): self
    {
        $this->chocolaterie = $chocolaterie;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getImageActu(): ?string
    {
        return $this->image_actu;
    }

    public function setImageActu(?string $image_actu): self
    {
        $this->image_actu = $image_actu;

        return $this;
    }

    public function getImageActuAlt(): ?string
    {
        return $this->image_actu_alt;
    }

    public function setImageActuAlt(?string $image_actu_alt): self
    {
        $this->image_actu_alt = $image_actu_alt;

        return $this;
    }

    public function getCratedAt(): ?\DateTimeImmutable
    {
        return $this->crated_at;
    }

    public function setCratedAt(\DateTimeImmutable $crated_at): self
    {
        $this->crated_at = $crated_at;

        return $this;
    }
}
