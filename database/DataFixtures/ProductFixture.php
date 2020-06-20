<?php

namespace DataFixtures;

use App\Domain\Product\Product;
use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Reference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $currency = new Currency('EUR');

        $list = [
            new Product(new Reference('01-AAAAAAAA'), 'Red pen', new Money(2.45, $currency), 50),
            new Product(new Reference('02-AAAAAAAA'), 'Blue pen', new Money(3.15, $currency), 150),
            new Product(new Reference('01-ACAAAAAA'), 'Note', new Money(5.40, $currency), 250),
            new Product(new Reference('01-AADAAAAA'), 'Scissors', new Money(6, $currency), 350),
            new Product(new Reference('01-AAAAZAAA'), 'Eraser', new Money(1.12, $currency), 450),
            new Product(new Reference('01-AAAAAJAA'), 'Pencil case', new Money(22.60, $currency), 550),
        ];

        foreach ($list as $item) {
            $manager->persist($item);
        }

        $manager->flush();
    }
}
