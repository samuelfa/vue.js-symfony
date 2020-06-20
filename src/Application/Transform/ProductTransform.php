<?php


namespace App\Application\Transform;

use App\Domain\Product\Product;
use App\Domain\ValueObject\Reference;

class ProductTransform
{
    private MoneyTransform $moneyTransform;

    public function __construct(MoneyTransform $moneyTransform)
    {
        $this->moneyTransform = $moneyTransform;
    }

    public function toArray(Product $product): array
    {
        return [
            'reference' => $product->reference(),
            'name' => $product->name(),
            'price' => $this->moneyTransform->toArray($product->price()),
            'stock' => $product->stock(),
        ];
    }

    public function fromArray(array $item): Product
    {
        $reference = new Reference($item['reference']);
        $price = $this->moneyTransform->fromArray($item['price']);

        return new Product($reference, $item['name'], $price, (int)$item['stock']);
    }
}