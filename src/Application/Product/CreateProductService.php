<?php


namespace App\Application\Product;


use App\Domain\Product\Product;
use App\Domain\Product\ProductRepository;

class CreateProductService
{
    private ProductRepository $repository;
    /**
     * @var string[]
     */
    private array            $currencies;

    public function __construct(ProductRepository $repository, array $currencies)
    {
        $this->repository = $repository;
        $this->currencies = $currencies;
    }

    public function __invoke(CreateProductDTO $dto): void
    {
        if(empty($dto->name())){
            throw new EmptyName();
        }

        if($dto->price()->quantity() <= 0){
            throw new InvalidPrice();
        }

        if(!in_array($dto->price()->currency(), $this->currencies, false)){
            throw new InvalidCurrency();
        }

        if($dto->stock() < 0){
            throw new InvalidStock();
        }

        $product = new Product(
            $dto->reference(),
            $dto->name(),
            $dto->price(),
            $dto->stock()
        );

        $this->repository->save($product);
    }

}