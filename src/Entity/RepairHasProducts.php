<?php

namespace App\Entity;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RepairHasProducts
{
    private UuidInterface $id;
    private int $quantity;
    private Repair $repair;
    private Product $product;
    private DateTimeImmutable $created;

    public function __construct(Repair $repair, Product $product, int $quantity)
    {
        $this->id = Uuid::uuid4();
        $this->quantity = $quantity;
        $this->repair = $repair;
        $this->product = $product;
        $this->created = new DateTimeImmutable('now');
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRepair(): Repair
    {
        return $this->repair;
    }

    public function setRepair(Repair $repair): self
    {
        $this->repair = $repair;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getCreated(): ?DateTimeImmutable
    {
        return $this->created;
    }
}