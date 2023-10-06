<?php

namespace App\Entity;

use App\Repository\DecouverteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DecouverteRepository::class)]
class Decouverte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomAffiche = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAffiche(): ?string
    {
        return $this->nomAffiche;
    }

    public function setNomAffiche(string $nomAffiche): static
    {
        $this->nomAffiche = $nomAffiche;

        return $this;
    }
}
