<?php

namespace App\Application\Product\Collection;

use App\Application\Transform\ProductTransform;
use App\Domain\Product\Product;
use App\Domain\Product\ProductRepository;

class ProductListService
{
    private ProductRepository $repository;
    private ProductTransform $productTransform;

    public function __construct(ProductRepository $repository, ProductTransform $productTransform)
    {
        $this->repository = $repository;
        $this->productTransform = $productTransform;
    }

    public function __invoke(): array
    {
        $list = $this->repository->findAll();

        return array_map(fn (Product $product) => $this->productTransform->toArray($product), $list);
    }
}
