<?php

namespace App\Entity;

use App\Repository\LogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $remoteHost = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $notification = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timeStamp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRemoteHost(): ?string
    {
        return $this->remoteHost;
    }

    public function setRemoteHost(string $remoteHost): static
    {
        $this->remoteHost = $remoteHost;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getNotification(): ?int
    {
        return $this->notification;
    }

    public function setNotification(int $notification): static
    {
        $this->notification = $notification;

        return $this;
    }

    public function getTimeStamp(): ?\DateTimeInterface
    {
        return $this->timeStamp;
    }

    public function setTimeStamp(\DateTimeInterface $timeStamp): static
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }

    public function getLogStatus(): ?int
    {
        return $this->log_status;
    }

    public function setLogStatus(int $log_status): static
    {
        $this->log_status = $log_status;

        return $this;
    }

}
