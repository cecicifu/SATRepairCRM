<?php

namespace App\Repository;

use App\Entity\Repair;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Repair|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repair|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repair[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends ServiceEntityRepository<Repair>
 */
class RepairRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repair::class);
    }

    /** @return array<Repair> */
    public function findAll(): array
    {
        return $this->findBy([], ['created' => 'DESC']);
    }
}
