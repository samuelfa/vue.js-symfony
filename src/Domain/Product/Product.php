<?php

namespace App\Domain\Product;


use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Reference;

class Product
{
    private Reference $reference;
    private string $name;
    private Money $price;
    private int $stock;
    private \DateTimeImmutable $createdAt;

    public function __construct(Reference $reference, string $name, Money $price, int $stock)
    {
        $this->reference = $reference;
        $this->name      = $name;
        $this->price     = $price;
        $this->stock     = $stock;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function reference(): Reference
    {
        return $this->reference;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function stock(): int
    {
        return $this->stock;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
