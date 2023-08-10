<?php

namespace App\DataFixtures;

use App\Entity\Log;
use App\Entity\RemoteHost;
use App\Repository\RemoteHostRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
//        for ($i = 0; $i<5; $i++) {
//            $remote = new RemoteHost();
//            $remote->setName("HOST_ $i");
//            $token = uniqid("$i _uni");
//            $remote->setToken($token);
//            $manager->persist($remote);
//        }

        for ($i = 0; $i < 20; $i++) {
            $rh = ($i%5)+1;
            $remoteHost = $manager->find(RemoteHost::class, '1');
            $log = new Log();
            $log->setRemoteHost($remoteHost);
            $log->setStatus($i%3);
            $tf = ($i % 2) ? 1 : 0;
            $log->setNotification($tf);
            $date = \DateTime::class('now');
            $log->setTimeStamp($date);
            $log->getMuteTime($date);
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
