<?php

namespace App\Service;

use App\Repository\RepairRepository;
use App\Entity\Repair;
use Doctrine\Common\Collections\Collection;

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

}