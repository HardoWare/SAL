<?php

namespace App\DataFixtures;

use App\Entity\RemoteHost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RemoteHostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i<5; $i++) {
            $remote = new RemoteHost();
            $remote->setName("HOST_{$i}");
            $token = uniqid("{$i}_uni");
            $remote->setToken($token);
            $manager->persist($remote);

        }
        $manager->flush();


    }
}
