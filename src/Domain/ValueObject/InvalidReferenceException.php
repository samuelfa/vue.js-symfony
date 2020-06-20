<?php

namespace App\Domain\ValueObject;

final class InvalidReferenceException extends \RuntimeException
{
    public function __construct($value)
    {
        parent::__construct("The reference {$value} has an invalid format");
    }

}
