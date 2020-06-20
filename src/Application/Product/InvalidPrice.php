<?php


namespace App\Application\Product;


class InvalidPrice extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('The money quantity must be higher than zero');
    }

}