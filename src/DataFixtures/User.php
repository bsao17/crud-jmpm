<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class User extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new \App\Entity\User();
        $user->setUsername('root')
            ->setPassword('root')
            ->setEmail('root@root.com')
            ->setRoles((array)'ROLE_ADMIN');
        $encoded = $this->encoder->encodePassword($user ,$user->getPassword());
        $user->setPassword($encoded);
        $manager->persist($user);
        $manager->flush();
    }
}
