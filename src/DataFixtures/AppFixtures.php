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

        $status = new Status(Uuid::fromString('4b0bdf60-1f41-4bf0-b412-98ce5a2def6e'));
        $status->setName('finished');
        $status->setColour('#008000');
        $status->setCreated(new DateTimeImmutable("now"));
        $status->setModified(new DateTime("now"));

        $manager->persist($status);

        $status = new Status(Uuid::fromString('4ec90cce-c206-495d-a117-b3858a57f658'));
        $status->setName('cancelled');
        $status->setColour('#FF0000');
        $status->setCreated(new DateTimeImmutable("now"));
        $status->setModified(new DateTime("now"));

        $manager->persist($status);

        $status = new Status(Uuid::fromString('c30655c7-7f3e-4537-8cf9-ebdf0a99af6a'));
        $status->setName('holded');
        $status->setColour('#808080');
        $status->setCreated(new DateTimeImmutable("now"));
        $status->setModified(new DateTime("now"));

        $manager->persist($status);

        $status = new Status(Uuid::fromString('b0419e17-ab79-4c75-ad99-b792daab6f37'));
        $status->setName('queued');
        $status->setColour('#FFFF00');
        $status->setCreated(new DateTimeImmutable("now"));
        $status->setModified(new DateTime("now"));

        $manager->persist($status);

        $status = new Status(Uuid::fromString('ec4cb5a9-6db9-4b13-b965-3320ec0fdca7'));
        $status->setName('waiting');
        $status->setColour('#FFFFFF');
        $status->setCreated(new DateTimeImmutable("now"));
        $status->setModified(new DateTime("now"));

        $manager->persist($status);

        $product = new Product(Uuid::fromString('b6a39dd8-8f0f-4096-8e4a-e8badaecbccc'));
        $product->setName('product1');
        $product->setAmount(40);
        $product->setCreated(new DateTimeImmutable("now"));
        $product->setModified(new DateTime("now"));

        $manager->persist($product);

        $product = new Product(Uuid::fromString('6ce2f22e-3180-40b7-95ae-b0b7db7a6c66'));
        $product->setName('product2');
        $product->setAmount(23);
        $product->setCreated(new DateTimeImmutable("now"));
        $product->setModified(new DateTime("now"));

        $manager->persist($product);

        $product = new Product(Uuid::fromString('78b32c83-9ce6-43b2-b15d-54ece9273eda'));
        $product->setName('product3');
        $product->setAmount(3);
        $product->setCreated(new DateTimeImmutable("now"));
        $product->setModified(new DateTime("now"));

        $manager->persist($product);

        $customer = new Customer(Uuid::fromString('48afa7c3-c3b3-412d-8c74-5e48253d68bd'));
        $customer->setFullname('customer1');
        $customer->setPhone(45353453453);
        $customer->setCreated(new DateTimeImmutable("now"));
        $customer->setModified(new DateTime("now"));

        $manager->persist($customer);

        $category = new Category(Uuid::fromString('2b6dc167-6dfd-42b6-a027-26e7b024e7cb'));
        $category->setName('category1');
        $category->setCreated(new DateTimeImmutable("now"));
        $category->setModified(new DateTime("now"));

        $manager->persist($category);

        $manager->flush();
    }
}
