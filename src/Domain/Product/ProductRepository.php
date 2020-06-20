<?php

namespace App\Domain\Product;

use App\Domain\ValueObject\Reference;

interface ProductRepository
{
    public function findOneByReference(Reference $nif): ?Product;
    /**
     * @return Product[]
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function findAll();
    public function save(Product $product): void;
    public function remove(Product $product): void;
}
