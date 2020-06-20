<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Product\Product;
use App\Domain\Product\ProductRepository as ProductRepositoryInterface;
use App\Domain\ValueObject\Reference;
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
        $this->_em->flush();
    }

    public function findOneByReference(Reference $reference): ?Product
    {
        /** @var Product|null $entity */
        $entity = $this->find((string) $reference);

        return $entity;
    }

    public function remove(Product $product): void
    {
        $this->_em->remove($product);
        $this->_em->flush();
    }
}
