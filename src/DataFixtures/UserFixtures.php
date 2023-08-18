<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $email = "user{$i}@mail.com";
            $user->setEmail($email);
            $pass = "passwd{$i}";
            $user->setPassword($pass);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        $user = new User();
        $email = "admin@mail.com";
        $user->setEmail($email);
        $pass = "adminpasswd";
        $user->setPassword($pass);
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
