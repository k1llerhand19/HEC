<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomVideo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVideo(): ?string
    {
        return $this->nomVideo;
    }

    public function setNomVideo(string $nomVideo): static
    {
        $this->nomVideo = $nomVideo;

        return $this;
    }
}
