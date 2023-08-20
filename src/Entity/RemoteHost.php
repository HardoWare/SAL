<?php

namespace App\Entity;

use App\Repository\RemoteHostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RemoteHostRepository::class)]
class RemoteHost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]    //TODO nullable false
    private ?\DateTimeInterface $intervalStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]    //TODO nullable false
    private ?\DateTimeInterface $intervalEnd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getIntervalStart(): ?\DateTimeInterface
    {
        return $this->intervalStart;
    }

    public function setIntervalStart(\DateTimeInterface $intervalStart): static
    {
        $this->intervalStart = $intervalStart;

        return $this;
    }

    public function getIntervalEnd(): ?\DateTimeInterface
    {
        return $this->intervalEnd;
    }

    public function setIntervalEnd(\DateTimeInterface $intervalEnd): static
    {
        $this->intervalEnd = $intervalEnd;

        return $this;
    }
}
