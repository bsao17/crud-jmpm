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
        for ($i=0; $i<=2; $i++){
            $user = new \App\Entity\User();
            $user->setUsername('bsao17')
                ->setPassword('123456')
                ->setEmail('declic62@gmail.com')
                ->setRoles((array)'ROLE_ADMIN');
            $encoded = $this->encoder->encodePassword($user ,$user->getPassword());
            $user->setPassword($encoded);
            $manager->persist($user);

        }
        $manager->flush();
    }
}
