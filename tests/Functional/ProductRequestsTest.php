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
        $values = [
            'reference' => '54-ABCDEFGH',
            'name' => 'Red Pen',
            'money' => 2.25,
            'currency' => 'EUR',
            'stock' => 50,
        ];
        $client->xmlHttpRequest('PUT', '/product', $values);

        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $list = $this->listProducts($client);
        $this->assertCount(1, $list);

        [$product] = $list;

        $this->assertEquals($values['reference'], $product['reference']);
        $this->assertEquals($values['name'], $product['name']);
        $this->assertEquals($values['money'], $product['price']['value']);
        $this->assertEquals($values['currency'], $product['price']['currency']);
        $this->assertEquals($values['stock'], $product['stock']);
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
}