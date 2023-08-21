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
            $pass = "user{$i}";
            $user->setPassword(password_hash($pass,null));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        $user = new User();
        $email = "admin@mail.com";
        $user->setEmail($email);
        $pass = "admin";
        $user->setPassword(password_hash($pass,null));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user = new User();
        $email = "superadmin@mail.com";
        $user->setEmail($email);
        $pass = "superadmin";
        $user->setPassword(password_hash($pass,null));
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
