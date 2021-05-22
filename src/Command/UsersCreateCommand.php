<?php

namespace App\Command;

use App\Entity\User;
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
    protected static $defaultName = 'users:create';
    protected static $defaultDescription = 'Create an user';

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
        $this->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask("Username", null, function ($username) {
			if (strlen($username) > 30) {
				throw new RuntimeException(
					'Username is too long, max 30.'
				);
			}

			return $username;
		});

		$password = $io->askHidden("Password");

		$user = new User(Uuid::uuid4());
		$user->setCreated(new DateTimeImmutable('now'));
		$user->setUsername($username);
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
