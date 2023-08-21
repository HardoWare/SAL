<?php

namespace App\DataFixtures;

use App\Entity\Log;
use App\Repository\RemoteHostRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LogFixtures extends Fixture
{
    public function __construct(private readonly RemoteHostRepository $hostRepository)
    {}
    public function load(ObjectManager $manager): void
    {
        $mess = ["mess1","mess2","mess3","mess4","mess5" ];

        for ($i = 0; $i < 20; $i++) {
            $rh = $i%5+1;
            $remoteHost = $this->hostRepository->find($rh);
            $log = new Log();
            $log->setRemoteHost($remoteHost);
            $log->setStatus($i%3);
            $tf = ($i % 2) ? 1 : 0;
            $log->setNotification($tf);
            $date = new \DateTime('now');
            $log->setTimeStamp($date);
            $log->setLogTimeStamp($date);
            $t = $i%5;
            $log->setLogMessage($mess[$t]);
            $manager->persist($log);
        }

        //$manager->flush();
    }
}
