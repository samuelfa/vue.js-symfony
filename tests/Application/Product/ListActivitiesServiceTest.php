<?php


namespace Test\Application\Product;


use App\Application\Product\ProductListService;
use App\Application\Transform\MoneyTransform;
use App\Application\Transform\ProductTransform;
use App\Domain\Product\Product;
use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Reference;
use App\Infrastructure\Persistence\InMemory\ProductRepository;
use PHPUnit\Framework\TestCase;

class ListActivitiesServiceTest extends TestCase
{
    private ProductRepository $repository;
    private ProductListService $handler;

    protected function setUp(): void
    {
        $this->repository = new ProductRepository([]);
        $moneyTransform   = new MoneyTransform();
        $productTransform = new ProductTransform($moneyTransform);
        $this->handler    = new ProductListService($this->repository, $productTransform);
    }

    public function testListActivities(): void
    {
        $values = [
            '54-ABCDEFGH' => 'Red pen',
            '34-gasfgiug' => 'Blue pen',
            '24-asfgsIUY' => 'Blackboard',
            '14-asgJFJLK' => 'Note'
        ];
        $currencies = ['EUR', 'USD'];
        foreach ($values as $reference => $name){
            $money = random_int(1, 350) / 100;
            $keyCurrency = array_rand($currencies);
            $currency = $currencies[$keyCurrency];
            $stock = random_int(0, 5000);
            $this->createActivity($reference, $name, $money, $currency, $stock);
        }

        $expectedList = $this->repository->findAll();
        $this->assertCount(4, $expectedList);

        /** @var Product[] $givenList */
        $givenList = $this->handler->__invoke();
        $this->assertCount(4, $givenList);

        foreach ($givenList as $rawProduct){
            $originalName = $values[$rawProduct['reference']];
            $product = $this->repository->findOneByReference(new Reference($rawProduct['reference']));
            $this->assertInstanceOf(Product::class, $product);

            $this->assertEquals($originalName, $rawProduct['name']);
            $this->assertEquals($originalName, $product->name());

            $this->assertEquals($rawProduct['reference'], $product->reference()->value());
            $this->assertEquals($rawProduct['name'], $product->name());
            $this->assertEquals($rawProduct['stock'], $product->stock());
            $this->assertEquals($rawProduct['price']['value'], $product->price()->quantity());
            $this->assertEquals($rawProduct['price']['currency'], $product->price()->currency()->value());
        }
    }

    private function createActivity(string $reference, string $name, float $money, string $currency, int $stock): void
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