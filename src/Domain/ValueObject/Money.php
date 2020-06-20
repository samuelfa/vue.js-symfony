<?php

namespace App\Domain\ValueObject;

final class Money
{
    private float $quantity;
    private Currency $currency;

    public function __construct(float $quantity, Currency $currency)
    {
        $this->quantity = $quantity;
        $this->currency = $currency;
    }

    public function quantity(): float
    {
        return $this->quantity;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function sum(?self $money): self
    {
        if (null === $money) {
            return $this;
        }

        if (!$this->currency->equals($money->currency())) {
            throw new InvalidCurrency($money->currency);
        }

        $value = $this->quantity() + $money->quantity();

        return new self($value, $this->currency);
    }

    public function subtract(self $money): self
    {
        if (!$this->currency->equals($money->currency())) {
            throw new InvalidCurrency($money->currency);
        }

        $value = $this->quantity() - $money->quantity();

        return new self($value, $this->currency);
    }

    public function empty(): self
    {
        return new self(0, $this->currency());
    }

    public function __toString()
    {
        return $this->quantity.' '.$this->currency;
    }
}
