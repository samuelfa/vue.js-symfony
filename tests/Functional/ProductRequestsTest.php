<?php

namespace Test\Functional;

use App\Domain\Product\Product;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductRequestsTest extends WebTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
        $this->truncateEntities([
            Product::class,
        ]);
    }

    public function testProductListEmpty(): void
    {
        $client = static::createClient();
        $list = $this->listProducts($client);
        $this->assertCount(0, $list);
    }

    public function testCreateProductAndList(): void
    {
        $client = static::createClient();

        $reference = '54-ABCDEFGH';
        $name = 'Red pen';
        $money = 2.25;
        $currency = 'EUR';
        $stock = 50;
        $this->createProduct($client, $reference, $name, $money, $currency, $stock);

        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $list = $this->listProducts($client);
        $this->assertCount(1, $list);

        [$product] = $list;

        $this->assertEquals($reference, $product['reference']);
        $this->assertEquals($name, $product['name']);
        $this->assertEquals($money, $product['price']['value']);
        $this->assertEquals($currency, $product['price']['currency']);
        $this->assertEquals($stock, $product['stock']);
    }

    public function testDeleteProduct(): void
    {
        $client = static::createClient();

        $reference = '54-ABCDEFGH';
        $name = 'Red pen';
        $money = 2.25;
        $currency = 'EUR';
        $stock = 50;
        $this->createProduct($client, $reference, $name, $money, $currency, $stock);

        $client->xmlHttpRequest('DELETE', '/product/'.$reference);

        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $list = $this->listProducts($client);
        $this->assertCount(0, $list);
    }

    private function listProducts(KernelBrowser $client): array
    {
        $client->xmlHttpRequest('GET', '/product/list');

        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $content = $response->getContent();

        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }

    private function truncateEntities(array $entities): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
        }
        foreach ($entities as $entity) {
            $query = $databasePlatform->getTruncateTableSQL(
                $this->getEntityManager()->getClassMetadata($entity)->getTableName()
            );
            $connection->executeUpdate($query);
        }
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    private function getEntityManager(): EntityManager
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    private function createProduct(KernelBrowser $client, string $reference, string $name, float $money, string $currency, int $stock): void
    {
        $values = [
            'reference' => $reference,
            'name' => $name,
            'money' => $money,
            'currency' => $currency,
            'stock' => $stock,
        ];
        $client->xmlHttpRequest('PUT', '/product', [], [], [], json_encode($values, JSON_THROW_ON_ERROR));
    }
}
