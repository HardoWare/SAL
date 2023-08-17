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

    #[ORM\Column(type: Types::ARRAY)]
    private array $logData = [];

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

    public function getLogData(): array
    {
        return $this->logData;
    }

    public function setLogData(array $logData): static
    {
        $this->logData = $logData;

        return $this;
    }

    public function getRemoteHostName(): string
    {
        return $this->remoteHost->getName();
    }

    public function getTimeStampString(): string
    {
        return $this->getTimeStamp()->format("Y-m-d H:i:s");
    }

    public function getMuteTimeString(): string
    {
        return $this->getMuteTime()->format("Y-m-d H:i:s");
    }

    public function getLogDataTimeStamp(): string
    {
        $arr = $this->getLogData();
        return $arr["time_stamp"];
    }

    public function getLogDataMessage(): string
    {
        $arr = $this->getLogData();
        return $arr["message"];
    }
}
