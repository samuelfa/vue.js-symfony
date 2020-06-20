<?php

namespace App\Application\Product\Delete;

use App\Domain\ValueObject\Reference;

class DeleteProductDTO
{
    private Reference $reference;

    public function __construct(string $reference)
    {
        $this->reference = new Reference($reference);
    }

    public function reference(): Reference
    {
        return $this->reference;
    }
}
