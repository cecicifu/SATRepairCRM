<?php

namespace App\Command;

use App\Entity\Repair;
use App\Service\RepairService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BatchRepairHideCommand extends Command
{
    protected static $defaultName = 'batch:repair:hide';
    protected static $defaultDescription = 'Hide repairs where the created date is greater than specified days';

    private RepairService $repairService;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, RepairService $repairService)
    {
        parent::__construct();
        $this->repairService = $repairService;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
			->setDescription(self::$defaultDescription)
			->addOption('days', null, InputOption::VALUE_REQUIRED, 'Number of days')
		;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
		$days = (int) $input->getOption('days');

		if (!$days || $days === 0) {
			$io->error('You need to specify the numbers of days, use --days option.');
			return Command::FAILURE;
		}

        $repairs = $this->repairService->findAll();
        $totalRepairs = 0;

		/* @var Repair $repair */
		foreach ($repairs as $repair) {
            $interval = $repair->getCreated()->diff(new DateTime('now'));
            $daysDiff = (int) $interval->format("%a");

            if($daysDiff >= $days && $repair->isVisible()) {
                $repair->setVisible(false);
                $this->entityManager->flush();
                $totalRepairs++;
            }
        }

        $io->success(sprintf('Repairs hidden: %s', $totalRepairs));

        return Command::SUCCESS;
    }
}
