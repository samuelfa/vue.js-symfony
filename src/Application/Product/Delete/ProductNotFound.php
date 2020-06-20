<?php

namespace App\Application\Product\Delete;

use App\Domain\ValueObject\Reference;

class ProductNotFound extends \RuntimeException
{
    public function __construct(Reference $reference)
    {
        parent::__construct(sprintf('Product with reference %s not found', $reference));
    }
}
