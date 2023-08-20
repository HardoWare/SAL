<?php

namespace App\Service;

use App\Entity\Log;
use App\Entity\RemoteHost;
use App\Repository\LogRepository;
use App\Repository\RemoteHostRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;

class DatabaseService
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly LogRepository $logRepository,
        private readonly RemoteHostRepository $remoteHostRepository
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
            $lts = new \DateTime("{$hostLog["time_stamp"]["date"]}");
            $log->setLogTimeStamp($lts);
            $log->setLogMessage($hostLog["message"]);
            $this->manager->persist($log);
        }
        $this->manager->flush();
    }
    public function insertPolaczenie(RemoteHost $remoteHost): void
    {
        $log = new Log();
        $log->setRemoteHost($remoteHost);
        $log->setStatus(0);
        $log->setNotification(0);
        $date = new \DateTime('now');
        $log->setTimeStamp($date);
        $log->setMuteTime($date);
        $log->setLogData(["message"=>"200"]);
        $this->manager->persist($log);
        $this->manager->flush();
    }

    public function getOstatniePolaczeniaZApi(): array|null
    {
        $remoteHosts = $this->remoteHostRepository->getAllRemoteHostsIdAndInterval();
        $remoteHostsLastLog_arr = [];
        $date_now = new \DateTime("now");
        foreach ($remoteHosts as $remoteHost) {
            $log = $this->logRepository->selectIstatniLogRemoteHosta($remoteHost["id"]);
            $interval = $remoteHost["intervalEnd"]->diff($remoteHost["intervalStart"]);

            $logTimeStamp_interval = clone $log->getTimeStamp();
            $logTimeStamp_interval->add($interval);
            $time_diff = $date_now->diff($logTimeStamp_interval);

            $remoteHostsLastLog_arr[] = [
                "remoteHostName" => $log->getRemoteHostName(),
                "timeStamp" => $log->getTimeStamp()->format("Y-m-d H:i:s"),
                "interval" => $interval->format("%H:%i:%s"),
                "timeDiff" => $time_diff->format("%d days %H:%i:%s"),
                ];
        }
        return $remoteHostsLastLog_arr;
    }

    public function getDzisiejseBledy(): array|null
    {
        return $this->logRepository->getDisiejszeLogiZError();
    }
}