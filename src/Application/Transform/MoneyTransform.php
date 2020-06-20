<?php


namespace App\Application\Transform;


use App\Domain\ValueObject\Currency;
use App\Domain\ValueObject\Money;

class MoneyTransform
{
    public function toArray(?Money $price): ?array
    {
        if($price === null){
            return null;
        }

        return [
            'value' => $price->quantity(),
            'currency' => (string) $price->currency()
        ];
    }

    public function fromArray(?array $raw): ?Money
    {
        if($raw === null){
            return null;
        }

        return new Money((float) $raw['value'], new Currency($raw['currency']));
    }
}