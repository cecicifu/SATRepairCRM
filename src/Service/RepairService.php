<?php

namespace App\Service;

use App\Repository\RepairRepository;
use App\Entity\Repair;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Config\Definition\Exception\Exception;

class RepairService
{
    private RepairRepository $repairRepository;

    public function __construct(RepairRepository $repairRepository)
    {
        $this->repairRepository = $repairRepository;
    }

    public function findAll(): array
    {
        return $this->repairRepository->findAll();
    }

    public function findByCode(string $code): ?Repair
    {
        return $this->repairRepository->findOneBy(['code' => $code]);
    }

    public function findRepairProducts(Repair $repair): ?Collection
    {
        $repair = $this->repairRepository->find($repair);
        return $repair->getProducts();
    }

    public function countRepairProducts(Repair $repair): ?int
    {
        $repair = $this->repairRepository->find($repair);
        return $repair->getProducts()->count();
    }

    public function updateRepairProductAmount(Repair $repair): Repair
    {
        foreach ($repair->getProducts() as $productToAdd) {
            $product = $productToAdd->getProduct();

            if($productToAdd->getQuantity() <= 0) {
                throw new Exception("Quantity should be positive");
            }

            if($productToAdd->getQuantity() === 0) {
                throw new Exception("Quantity cannot be zero");
            }

            if ($product->getAmount() < $productToAdd->getQuantity()) {
                throw new Exception("Product {$product->getName()} amount not enough");
            }

            if(!$productToAdd->getRepair()) {
                $productToAdd->setRepair($repair);
            }

            $repair->addProduct($productToAdd);
            $product->setAmount($product->getAmount() - $productToAdd->getQuantity());
        }
        return $repair;
    }
}