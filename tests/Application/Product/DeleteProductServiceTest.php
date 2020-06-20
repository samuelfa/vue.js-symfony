<?php

namespace Test\Application\Product;

use App\Application\Product\Delete\DeleteProductDTO;
use App\Application\Product\Delete\DeleteProductService;
use App\Application\Product\Delete\ProductNotFound;
use App\Domain\Product\Product;
use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Reference;
use App\Infrastructure\Persistence\InMemory\ProductRepository;
use PHPUnit\Framework\TestCase;

class DeleteProductServiceTest extends TestCase
{
    private ProductRepository $repository;
    private DeleteProductService $handler;

    protected function setUp(): void
    {
        $this->repository = new ProductRepository([]);
        $this->handler = new DeleteProductService($this->repository);
    }

    public function testDeleteProduct(): void
    {
        $list = $this->repository->findAll();
        $this->assertEmpty($list);

        $reference = '54-ABCDEFGH';
        $name = 'Red Pen';
        $money = 2.25;
        $currency = 'EUR';
        $stock = 50;

        $this->createProduct($reference, $name, $money, $currency, $stock);

        $list = $this->repository->findAll();
        $this->assertNotEmpty($list);

        $this->handler->__invoke(new DeleteProductDTO($reference));

        $list = $this->repository->findAll();
        $this->assertEmpty($list);
    }

    public function testFailWhenNameIsEmpty(): void
    {
        $reference = '54-ABCDEFGH';

        $this->expectException(ProductNotFound::class);
        $this->handler->__invoke(new DeleteProductDTO($reference));
    }

    private function createProduct(string $reference, string $name, float $money, string $currency, int $stock): void
    {
        $activity = new Product(
            new Reference($reference),
            $name,
            new Money($money, new Currency($currency)),
            $stock
        );
        $this->repository->save($activity);
    }
}
