<?php

namespace App\DataFixtures;

use App\Entity\Log;
use App\Repository\RemoteHostRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LogFixtures extends Fixture
{
    public function __construct(private RemoteHostRepository $hostRepository)
    {}
    public function load(ObjectManager $manager): void
    {
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
            $log->setMuteTime($date);
            $log->setLogData([
                "id"  => rand(1,100),
                "time_stamp" => "$i _ts123",
                "message" => "$i _messText",
                "status" => "1",
            ]);
            $manager->persist($log);
        }

        $manager->flush();
    }
}
