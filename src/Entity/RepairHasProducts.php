<?php

namespace App\Entity;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RepairHasProducts
{
    private UuidInterface $id;
    private ?Repair $repair;
    private Product $product;
    private int $quantity;
    private DateTimeImmutable $created;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->repair = null;
        $this->created = new DateTimeImmutable('now');
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRepair(): ?Repair
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

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(DateTimeImmutable $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function __toString()
    {
        return "Product: {$this->getProduct()->getName()} - Quantity: {$this->getQuantity()}";
    }
}