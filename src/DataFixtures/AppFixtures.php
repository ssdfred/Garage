<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct( UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
       // $fred = new User();
       // $fred->setNom("fred")->setEmail("fred@fred.fr")->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
       // $password= $this->passwordHasher->hashPassword( $fred, "123456");
       // $fred->setPassword($password);
       // $manager->persist($fred);
//

        $manager->flush();
    }
}
