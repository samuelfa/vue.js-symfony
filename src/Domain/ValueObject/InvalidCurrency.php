<?php


namespace App\Domain\ValueObject;


final class InvalidCurrency extends \RuntimeException
{
    public function __construct(Currency $currency)
    {
        parent::__construct(sprintf('Invalid currency provided %s', $currency->value()));
    }

}