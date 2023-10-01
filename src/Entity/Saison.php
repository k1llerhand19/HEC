<?php

namespace App\Entity;

use App\Repository\SaisonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaisonRepository::class)]
class Saison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomDoc = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDoc(): ?string
    {
        return $this->nomDoc;
    }

    public function setNomDoc(string $nomDoc): static
    {
        $this->nomDoc = $nomDoc;

        return $this;
    }
}
