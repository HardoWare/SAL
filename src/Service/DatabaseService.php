<?php

namespace App\Service;

use App\Entity\Log;
use App\Entity\RemoteHost;
use App\Repository\LogRepository;
use App\Repository\RemoteHostRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\EntityIdentityCollisionException;
use Doctrine\ORM\Exception\ManagerException;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;

class DatabaseService
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly LogRepository $logRepository,
        private readonly RemoteHostRepository $remoteHostRepository
    )
    {}

    public function insertLogZStatusemError($hostLogs, RemoteHost $remoteHost): void
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
        $log->setLogTimeStamp($date);
        $log->setLogMessage("ok");
        $this->manager->persist($log);
        $this->manager->flush();
    }

    public function getOstatniePolaczeniaZApi(): array|null
    {
        $remoteHosts = $this->remoteHostRepository->findAll();
        $remoteHostsLastLog_arr = [];
        $date_now = new \DateTime("now");
        foreach ($remoteHosts as $remoteHost) {
            $log = $this->logRepository->selectOstatniLogRemoteHosta($remoteHost->getId());
            if ($log == null) {
                $remoteHostsLastLog_arr[] = [
                    "remoteHostName" => $remoteHost->getName(),
                ];
            }
            else {
                $interval = $remoteHost->getIntervalEnd()->diff($remoteHost->getIntervalStart());
                $logTimeStamp_interval = clone $log->getTimeStamp();
                $logTimeStamp_interval->add($interval);
                $time_diff = $date_now->diff($logTimeStamp_interval);
                $isInverted = $time_diff->invert;

                $remoteHostsLastLog_arr[] = [
                    "remoteHostName" => $log->getRemoteHostName(),
                    "timeStamp" => $log->getTimeStamp(),
                    "interval" => $interval,//->format("%H:%I:%S"),
                    "timeDiff" => $time_diff,//->format("%R %d days %H:%I:%S"),
                ];
            }
        }
        return $remoteHostsLastLog_arr;
    }

    public function getDzisiejseBledy(): array|null
    {
        return $this->logRepository->getDisiejszeLogiZError();
    }

    public function insertBledyWRequescie($remoteHost, $errorMessage): void
    {
        $log = new Log();
        $log->setRemoteHost($remoteHost);
        $log->setStatus(1);
        $log->setNotification(1);
        $date = new \DateTime('now');
        $log->setTimeStamp($date);
        $log->setLogTimeStamp($date);
        $log->setLogMessage($errorMessage);
        $this->manager->persist($log);
        $this->manager->flush();
    }
}