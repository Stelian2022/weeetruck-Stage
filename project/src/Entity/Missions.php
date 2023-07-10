<?php

namespace App\Entity;

use App\Repository\MissionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionsRepository::class)]
class Missions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Service = null;

    #[ORM\ManyToOne(inversedBy: 'mission_id')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): ?string
    {
        return $this->Service;
    }

    public function setService(string $Service): static
    {
        $this->Service = $Service;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
