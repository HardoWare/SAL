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

    #[ORM\ManyToOne(targetEntity: RemoteHost::class)]
    private ?RemoteHost $remoteHost = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $notification = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timeStamp = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $muteTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $logTimeStamp = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $logMessage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRemoteHost(): ?RemoteHost
    {
        return $this->remoteHost;
    }

    public function setRemoteHost(RemoteHost $remoteHost): static
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

    public function getMuteTime(): ?\DateTimeInterface
    {
        return $this->muteTime;
    }

    public function setMuteTime(\DateTimeInterface $muteTime): static
    {
        $this->muteTime = $muteTime;

        return $this;
    }

    public function getLogTimeStamp(): ?\DateTimeInterface
    {
        return $this->logTimeStamp;
    }

    public function setLogTimeStamp(?\DateTimeInterface $logTimeStamp): void
    {
        $this->logTimeStamp = $logTimeStamp;
    }

    public function getLogMessage(): ?string
    {
        return $this->logMessage;
    }

    public function setLogMessage(?string $logMessage): void
    {
        $this->logMessage = $logMessage;
    }

    public function getRemoteHostName(): string
    {
        return $this->remoteHost->getName();
    }

}
