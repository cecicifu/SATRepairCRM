<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = $this->createUser();

        $manager->persist($user);
        $manager->flush();
    }

    public function createUser(): User
    {
        $user = new User(Uuid::uuid4());
        $user->setUsername('admin');
        $user->setEmail('admin@admin.com');
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                'asdf,123'
            )
        );
        $user->setCreated(new \DateTimeImmutable("now"));
        $user->setModified(new \DateTime("now"));

        return $user;
    }
}
