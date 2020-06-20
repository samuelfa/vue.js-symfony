<?php

namespace App\Application\Product\Delete;

use App\Domain\Product\ProductRepository;

class DeleteProductService
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteProductDTO $dto): void
    {
        $product = $this->repository->findOneByReference($dto->reference());

        if (!$product) {
            throw new ProductNotFound($dto->reference());
        }

        $this->repository->remove($product);
    }
}
