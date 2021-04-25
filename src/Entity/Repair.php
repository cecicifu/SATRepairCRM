<?php

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Repair
{
    private UuidInterface $id;
    private Customer $customer;
    private Category $category;
    private Status $status;
    private Collection $products;
    private ?string $code;
    private ?int $imei;
    private ?string $pattern;
    private string $fault;
    private ?string $colour;
    private ?string $privateComment;
    private ?string $publicComment;
    private ?float $labourPrice;
    private ?float $tax;
    private bool $visible;
    private DateTimeInterface $modified;
    private DateTimeImmutable $created;

    public function __construct(UuidInterface $uuid)
    {
        $this->id = $uuid;
        $this->products = new ArrayCollection();
        $this->setVisible(true);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(RepairHasProducts $product): self
    {
        if (!$this->products->contains($product))
        {
            $this->products->add($product);
        }

        return $this;
    }

    public function removeProduct(RepairHasProducts $product): self
    {
        if ($this->products->contains($product))
        {
            $this->products->removeElement($product);
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getImei(): ?int
    {
        return $this->imei;
    }

    public function setImei(?int $imei): self
    {
        $this->imei = $imei;

        return $this;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    public function setPattern(?string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    public function getFault(): string
    {
        return $this->fault;
    }

    public function setFault(string $fault): self
    {
        $this->fault = $fault;

        return $this;
    }

    public function getColour(): ?string
    {
        return $this->colour;
    }

    public function setColour(?string $colour): self
    {
        $this->colour = $colour;

        return $this;
    }

    public function getPrivateComment(): ?string
    {
        return $this->privateComment;
    }

    public function setPrivateComment(?string $privateComment): self
    {
        $this->privateComment = $privateComment;

        return $this;
    }

    public function getPublicComment(): ?string
    {
        return $this->publicComment;
    }

    public function setPublicComment(?string $publicComment): self
    {
        $this->publicComment = $publicComment;

        return $this;
    }

    public function getLabourPrice(): ?float
    {
        return $this->labourPrice;
    }

    public function setLabourPrice(?float $labourPrice): self
    {
        $this->labourPrice = $labourPrice;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(?float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getModified(): DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(DateTimeInterface $modified): self
    {
        $this->modified = $modified;

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
}
