<?php

namespace App\Application\Product\Create;

class EmptyName extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Empty name given');
    }
}
