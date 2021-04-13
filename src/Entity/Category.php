<?php

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class Category
{
    private UuidInterface $id;
    private string $name;
    private ?string $description;
    private DateTimeInterface $modified;
    private DateTimeImmutable $created;

    public function __construct(UuidInterface $uuid)
    {
        $this->id = $uuid;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
