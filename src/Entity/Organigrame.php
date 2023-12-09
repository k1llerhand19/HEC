<?php

namespace App\Entity;

use App\Repository\OrganigrameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganigrameRepository::class)]
class Organigrame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $Role = null;

    #[ORM\Column(length: 25)]
    private ?string $Nom = null;

    #[ORM\Column(length: 25)]
    private ?string $Prenom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Text = null;

    #[ORM\Column(length: 50)]
    public ?string $Nom_Photos = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): static
    {
        $this->Role = $Role;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): static
    {
        $this->Text = $Text;

        return $this;
    }

    public function getNomPhotos(): ?string
    {
        return $this->Nom_Photos;
    }

    public function setNomPhotos(string $nom_photos): static
    {
        $this->Nom_Photos = $nom_photos;

        return $this;
    }
}
