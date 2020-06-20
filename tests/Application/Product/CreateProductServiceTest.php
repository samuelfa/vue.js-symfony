<?php


namespace Test\Application\Product;


use App\Application\Product\CreateProductDTO;
use App\Application\Product\CreateProductService;
use App\Application\Product\EmptyName;
use App\Application\Product\InvalidCurrency;
use App\Application\Product\InvalidPrice;
use App\Application\Product\InvalidStock;
use App\Infrastructure\Persistence\InMemory\ProductRepository;
use PHPUnit\Framework\TestCase;

class CreateProductServiceTest extends TestCase
{
    private ProductRepository $repository;
    private CreateProductService $handler;

    protected function setUp(): void
    {
        $this->repository = new ProductRepository([]);
        $this->handler = new CreateProductService($this->repository, ['EUR', 'USD']);
    }

    public function testCreateProduct(): void
    {
        $reference = '54-ABCDEFGH';
        $name = 'Red Pen';
        $money = 2.25;
        $currency = 'EUR';
        $stock = 50;

        $this->createProduct($reference, $name, $money, $currency, $stock);

        $list = $this->repository->findAll();
        $product = array_pop($list);

        $this->assertEquals($reference, $product->reference()->value());
        $this->assertEquals($name, $product->name());
        $this->assertEquals($money, $product->price()->quantity());
        $this->assertEquals($currency, $product->price()->currency()->value());
        $this->assertEquals($stock, $product->stock());

        $this->repository->remove($product);
    }

    public function testFailWhenNameIsEmpty(): void
    {
        $reference = '54-ABCDEFGH';
        $name = '';
        $money = 2.25;
        $currency = 'EUR';
        $stock = 50;

        $this->expectException(EmptyName::class);
        $this->createProduct($reference, $name, $money, $currency, $stock);
    }

    public function testFailWhenPriceIsEqualToZero(): void
    {
        $reference = '54-ABCDEFGH';
        $name = 'Red Pen';
        $money = 0;
        $currency = 'EUR';
        $stock = 50;

        $this->expectException(InvalidPrice::class);
        $this->createProduct($reference, $name, $money, $currency, $stock);
    }

    public function testFailWhenPriceIsNegative(): void
    {
        $reference = '54-ABCDEFGH';
        $name = 'Red Pen';
        $money = -0.1;
        $currency = 'ESP';
        $stock = 50;

        $this->expectException(InvalidPrice::class);
        $this->createProduct($reference, $name, $money, $currency, $stock);
    }

    public function testFailWhenCurrencyIsNotAcceptable(): void
    {
        $reference = '54-ABCDEFGH';
        $name = 'Red Pen';
        $money = 2.25;
        $currency = 'ESP';
        $stock = 50;

        $this->expectException(InvalidCurrency::class);
        $this->createProduct($reference, $name, $money, $currency, $stock);
    }

    public function testFailWhenStockIsNegative(): void
    {
        $reference = '54-ABCDEFGH';
        $name = 'Red Pen';
        $money = 2.25;
        $currency = 'EUR';
        $stock = -4;

        $this->expectException(InvalidStock::class);
        $this->createProduct($reference, $name, $money, $currency, $stock);
    }

    private function createProduct(
        string $reference,
        string $name,
        float  $money,
        string $currency,
        int    $stock
    ): void
    {
        $dto = new CreateProductDTO(
            $reference,
            $name,
            $money,
            $currency,
            $stock
        );

        $this->handler->__invoke($dto);
    }

}