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
use Faker\Generator;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private Generator $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
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
        $user->setCreated(new DateTimeImmutable("now"));
        $user->setModified(new DateTime("now"));

        $manager->persist($user);

        for ($i = 0; $i < 5; $i++) {
            $status = new Status(Uuid::uuid4());
            $status->setName($this->faker->unique()->word);
            $status->setColour($this->faker->hexColor);
            $status->setCreated(new DateTimeImmutable('now'));
            $status->setModified(new DateTime('now'));

            $manager->persist($status);
        }

        for ($i = 0; $i < 10; $i++) {
            $product = new Product(Uuid::uuid4());
            $product->setName($this->faker->word);
            $product->setPrice($this->faker->randomFloat(2, 0, 100));
            $product->setAmount($this->faker->randomNumber(2));
            $product->setCreated(new DateTimeImmutable('now'));
            $product->setModified(new DateTime('now'));

            $manager->persist($product);
        }

        for ($i = 0; $i < 10; $i++) {
            $customer = new Customer(Uuid::uuid4());
            $customer->setFullname($this->faker->name);
            $customer->setPhone($this->faker->randomNumber(9, true));
            $customer->setEmail($this->faker->email);
            $customer->setAddress($this->faker->address);
            $customer->setCity($this->faker->city);
            $customer->setZipCode($this->faker->randomNumber(5, true));
            $customer->setCreated(new DateTimeImmutable('now'));
            $customer->setModified(new DateTime('now'));

            $manager->persist($customer);
        }

        for ($i = 0; $i < 5; $i++) {
            $category = new Category(Uuid::uuid4());
            $category->setName($this->faker->word);
            $category->setDescription($this->faker->text);
            $category->setCreated(new DateTimeImmutable('now'));
            $category->setModified(new DateTime('now'));

            $manager->persist($category);
        }

        $manager->flush();
    }
}
