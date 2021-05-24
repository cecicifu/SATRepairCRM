<?php

namespace App\Command;

use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersCreateCommand extends Command
{
    private string $name = 'users:create';
    private string $description = 'Create an user';

    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure(): void
    {
        $this
            ->setName($this->name)
            ->setDescription($this->description)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask('Username', null, function ($username) {
            if (strlen($username) > 30) {
                throw new RuntimeException('Username is too long, max 30.');
            }

            if (!$username) {
                throw new RuntimeException('Username cant be null.');
            }

            return $username;
        });

        $email = $io->ask('Email');

        $roles[] = $io->choice('Role', ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN'], 'ROLE_ADMIN');

        $password = $io->askHidden('Password', function ($password) {
            if (!$password) {
                throw new RuntimeException('Password cant be null.');
            }

            return $password;
        });

        $user = new User(Uuid::uuid4());
        $user->setModified(new DateTime('now'));
        $user->setCreated(new DateTimeImmutable('now'));
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $password
            )
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('User created succesfully!');

        return Command::SUCCESS;
    }
}
