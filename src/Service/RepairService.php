<?php

namespace App\Service;

use App\Entity\Repair;
use App\Repository\RepairRepository;

class RepairService
{
    private RepairRepository $repairRepository;

    public function __construct(RepairRepository $repairRepository)
    {
        $this->repairRepository = $repairRepository;
    }

    /** @return array<Repair> */
    public function findAll(): array
    {
        return $this->repairRepository->findAll();
    }

    public function findByCode(string $code): ?Repair
    {
        return $this->repairRepository->findOneBy(['code' => $code]);
    }

    public function updateRepairProductAmount(Repair $repair): void
    {
        foreach ($repair->getProducts() as $productToAdd) {
            $product = $productToAdd->getProduct();

            $productToAdd->setRepair($repair);

            $repair->addProduct($productToAdd);
            $product->setAmount($product->getAmount() - $productToAdd->getQuantity());
        }
    }
}
