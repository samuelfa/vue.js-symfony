<?php

namespace App\Application\Product\Create;

class ReferenceAlreadyUsed extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('The reference provided is already used');
    }
}
