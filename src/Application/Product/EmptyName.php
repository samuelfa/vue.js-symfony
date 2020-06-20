<?php


namespace App\Application\Product;


class EmptyName extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Empty name given');
    }

}