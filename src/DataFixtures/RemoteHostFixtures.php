<?php

namespace App\DataFixtures;

use App\Entity\RemoteHost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RemoteHostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $date_now = new \DateTime("now");
        for ($i = 0; $i<5; $i++) {
            $remote = new RemoteHost();
            $remote->setName("HOST_{$i}");
            $token = uniqid("{$i}_uni");
            $remote->setToken($token);
            $int = $i+ 10 * 20;
            $remote->setIntervalStart($date_now);
            $interval = new \DateTime("{$int} minutes ago");
            $remote->setIntervalEnd($interval);
            $manager->persist($remote);
        }
        $manager->flush();


    }
}
