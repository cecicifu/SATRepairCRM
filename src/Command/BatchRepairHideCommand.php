<?php

namespace App\Command;

use App\Service\RepairService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BatchRepairHideCommand extends Command
{
    protected static $defaultName = 'batch:repair:hide';
    protected static $defaultDescription = 'Hide repairs where the created date is greater than 90 days';

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
        $this->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $repairs = $this->repairService->findAll();
        $totalRepairs = 0;
        foreach ($repairs as $repair) {
            $interval = $repair->getCreated()->diff(new DateTime('now'));
            $days = (int) $interval->format("%a");

            if($days >= 90 && $repair->isVisible()) {
                $repair->setVisible(false);
                $this->entityManager->flush();
                $totalRepairs++;
            }
        }

        $io->success(sprintf('Repairs hidden: %s', $totalRepairs));

        return Command::SUCCESS;
    }
}
