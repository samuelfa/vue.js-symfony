<?php


namespace App\Application\Product;


use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Reference;

class CreateProductDTO
{
    private Reference $reference;
    private string $name;
    private Money $price;
    private int $stock;

    public function __construct(string $reference, string $name, float $money, string $currency, string $stock)
    {
        $this->reference = new Reference($reference);
        $this->name      = $name;
        $this->price     = new Money($money, new Currency($currency));
        $this->stock     = (int) $stock;
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
}