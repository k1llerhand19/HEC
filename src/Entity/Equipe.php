<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $TitreEquipe = null;

    #[ORM\Column(length: 15)]
    private ?string $jour1 = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $Horaire = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $Jour2 = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Horaire2 = null;

    #[ORM\Column(length: 255)]
    private ?string $Lieu = null;

    #[ORM\Column(length: 50)]
    private ?string $PhotoId = null;

    #[ORM\Column(length: 25)]
    private ?string $Nom = null;

    #[ORM\Column(length: 25)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 50)]
    private ?string $PhotoEquipe = null;

    #[ORM\Column(length: 255)]
    private ?string $CategorieEngagee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreEquipe(): ?string
    {
        return $this->TitreEquipe;
    }

    public function setTitreEquipe(string $TitreEquipe): static
    {
        $this->TitreEquipe = $TitreEquipe;

        return $this;
    }

    public function getJour1(): ?string
    {
        return $this->jour1;
    }

    public function setJour1(string $jour1): static
    {
        $this->jour1 = $jour1;

        return $this;
    }

    public function getHoraire(): ?\DateTimeInterface
    {
        return $this->Horaire;
    }

    public function setHoraire(\DateTimeInterface $Horaire): static
    {
        $this->Horaire = $Horaire;

        return $this;
    }

    public function getJour2(): ?string
    {
        return $this->Jour2;
    }

    public function setJour2(?string $Jour2): static
    {
        $this->Jour2 = $Jour2;

        return $this;
    }

    public function getHoraire2(): ?\DateTimeInterface
    {
        return $this->Horaire2;
    }

    public function setHoraire2(?\DateTimeInterface $Horaire2): static
    {
        $this->Horaire2 = $Horaire2;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->Lieu;
    }

    public function setLieu(string $Lieu): static
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function getPhotoId(): ?string
    {
        return $this->PhotoId;
    }

    public function setPhotoId(string $PhotoId): static
    {
        $this->PhotoId = $PhotoId;

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

    public function getPhotoEquipe(): ?string
    {
        return $this->PhotoEquipe;
    }

    public function setPhotoEquipe(string $PhotoEquipe): static
    {
        $this->PhotoEquipe = $PhotoEquipe;

        return $this;
    }

    public function getCategorieEngagee(): ?string
    {
        return $this->CategorieEngagee;
    }

    public function setCategorieEngagee(string $CategorieEngagee): static
    {
        $this->CategorieEngagee = $CategorieEngagee;

        return $this;
    }
}
