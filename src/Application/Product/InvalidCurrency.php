<?php


namespace App\Application\Product;


class InvalidCurrency extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid currency provided');
    }

}