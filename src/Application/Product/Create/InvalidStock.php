<?php

namespace App\Application\Product\Create;

class InvalidStock extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('The stock must be higher or equal to zero');
    }
}
