<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\Status;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $user = new User(Uuid::uuid4());
        $user->setUsername('admin');
        $user->setEmail('admin@admin.com');
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                'asdf,123'
            )
        );
        $user->setCreated(new DateTimeImmutable("now"));
        $user->setModified(new DateTime("now"));

        $manager->persist($user);

        for ($i = 0; $i < 5; $i++) {
            $status = new Status(Uuid::uuid4());
            $status->setName($faker->unique()->word);
            $status->setColour($faker->hexColor);
            $status->setCreated(new DateTimeImmutable('now'));
            $status->setModified(new DateTime('now'));

            $manager->persist($status);
        }

        for ($i = 0; $i < 10; $i++) {
            $product = new Product(Uuid::uuid4());
            $product->setName($faker->word);
            $product->setPrice($faker->randomFloat(2, 0, 100));
            $product->setAmount($faker->randomNumber(2));
            $product->setCreated(new DateTimeImmutable('now'));
            $product->setModified(new DateTime('now'));

            $manager->persist($product);
        }

        for ($i = 0; $i < 10; $i++) {
            $customer = new Customer(Uuid::uuid4());
            $customer->setFullname($faker->name);
            $customer->setPhone($faker->randomNumber(9, true));
            $customer->setEmail($faker->email);
            $customer->setAddress($faker->address);
            $customer->setCity($faker->city);
            $customer->setZipCode($faker->randomNumber(5, true));
            $customer->setCreated(new DateTimeImmutable('now'));
            $customer->setModified(new DateTime('now'));

            $manager->persist($customer);
        }

        for ($i = 0; $i < 5; $i++) {
            $category = new Category(Uuid::uuid4());
            $category->setName($faker->word);
            $category->setDescription($faker->text);
            $category->setCreated(new DateTimeImmutable('now'));
            $category->setModified(new DateTime('now'));

            $manager->persist($category);
        }

        $manager->flush();
    }
}
