<?php


namespace App\Infrastructure\Persistence\InMemory;


use App\Domain\Product\Product;
use App\Domain\ValueObject\Reference;

class ProductRepository implements \App\Domain\Product\ProductRepository
{
    /** @var Product[] */
    private array $list;

    /**
     * @param Product[] $list
     */
    public function __construct(array $list)
    {
        $this->list = [];
        foreach ($list as $element){
            $this->list[(string) $element->reference()] = $element;
        }
    }


    public function findOneByReference(Reference $reference): ?Product
    {
        return $this->list[(string) $reference] ?? null;
    }

    /**
     * @return Product[]
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function findAll()
    {
        return $this->list;
    }

    public function save(Product $product): void
    {
        $this->list[(string) $product->reference()] = $product;
    }

    public function remove(Product $product): void
    {
        unset($this->list[(string) $product->reference()]);
    }
}