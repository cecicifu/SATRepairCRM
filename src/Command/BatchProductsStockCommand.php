<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BatchProductsStockCommand extends Command
{
    protected static $defaultName = 'batch:products:stock';
    protected static $defaultDescription = 'Check product stock';

	private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
	{
		parent::__construct();
		$this->entityManager = $entityManager;
	}

	protected function configure(): void
    {
        $this->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

		$productRepository = $this->entityManager->getRepository(Product::class);

		$io->info("Products out of stock:");

		/* @var Product $product */
		foreach ($productRepository->findAll() as $product) {
			if($product->getAmount() === 0) {
				$io->note($product->getName());
			}
		}

        return Command::SUCCESS;
    }
}
