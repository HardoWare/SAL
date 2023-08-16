<?php

namespace App\Service;

use App\Entity\Log;
use App\Entity\RemoteHost;
use App\Repository\LogRepository;
use App\Repository\RemoteHostRepository;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseInserterService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private LogRepository $logRepository,
        private RemoteHostRepository $remoteHostRepository,
    )
    {}

    public function insertPolaczenieZLogami($hostLogs, RemoteHost $remoteHost): void
    {
        foreach ($hostLogs as $hostLog) {
            $log = new Log();
            $log->setRemoteHost($remoteHost);
            $log->setStatus($hostLog["status"]);
            $log->setNotification($hostLog["status"]);
            $date = new \DateTime('now');
            $log->setTimeStamp($date);
            $log->setMuteTime($date);
            $log->setLogData($hostLog);
            $this->manager->persist($log);
        }
        $this->manager->flush();
    }
    public function insertPolaczenie($remoteHost): void
    {
        $log = new Log();
        $log->setRemoteHost($remoteHost);
        $log->setStatus(0);
        $log->setNotification(0);
        $date = new \DateTime('now');
        $log->setTimeStamp($date);
        $log->setMuteTime($date);
        $log->setLogData(["0"=>"0"]);
        $this->manager->persist($log);
        $this->manager->flush();
    }
}