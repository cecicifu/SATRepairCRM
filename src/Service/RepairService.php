<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\RepairHasProducts;
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

    public function newRepairProductAmount(Product $product, RepairHasProducts $productToAdd): void
    {
        if ($product->getAmount() < $productToAdd->getQuantity()) {
            throw new Exception("Product {$product->getName()} amount not enough");
        }
        $product->setAmount($product->getAmount() - $productToAdd->getQuantity());
    }

    public function editRepairProductAmount(Repair $repair): void
    {
        foreach ($repair->getProducts() as $productToAdd) {
            if ($productToAdd->getQuantity() === 0) {
                $repair->removeProduct($productToAdd);
            } else {
                if ($productToAdd->getProduct()->getAmount() < $productToAdd->getQuantity()) {
                    throw new Exception("Product {$productToAdd->getProduct()->getName()} amount not enough");
                }

                if(!$productToAdd->getRepair()) {
                    $productToAdd->setRepair($repair);
                }

                $productToAdd->getProduct()->setAmount($productToAdd->getProduct()->getAmount() - $productToAdd->getQuantity());
            }
        }
    }

}