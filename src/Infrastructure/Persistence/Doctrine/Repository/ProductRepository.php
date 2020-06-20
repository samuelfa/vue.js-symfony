<?php


namespace App\Infrastructure\Persistence\Doctrine\Repository;


use App\Domain\ValueObject\Reference;
use App\Domain\Product\ProductRepository as ProductRepositoryInterface;
use App\Domain\Product\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $em)
    {
        parent::__construct($em, Product::class);
    }

    public function save(Product $product): void
    {
        $this->_em->persist($product);
    }

    public function findOneByReference(Reference $reference): ?Product
    {
        /** @var null|Product $entity */
        $entity = $this->find((string) $reference);
        return $entity;
    }

    public function flush(): void
    {
        $this->_em->flush();
    }

    public function remove(Product $product): void
    {
        $this->_em->remove($product);
    }
}