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
        $json =  '[{
                "id": 2,
                "time_stamp": {
                    "date": "2023-08-15 17:35:36.000000",
                    "timezone_type": 3,
                    "timezone": "Europe\/Berlin"
                },
                "status": 1,
                "message": "86"
            }]';
        $data = json_decode($json, true);
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
            $log->setLogData([$data]);
            $manager->persist($log);
        }

        $manager->flush();
    }
}
