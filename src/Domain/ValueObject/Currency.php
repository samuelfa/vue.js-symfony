<?php


namespace App\Domain\ValueObject;


final class Currency
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }

    public function equals(Currency $currency): bool
    {
        return $this->value === $currency->value();
    }
}