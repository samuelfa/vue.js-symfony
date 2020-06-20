<?php


namespace App\Domain\ValueObject;

final class Reference
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        if (!$this->isValidFormat($value)) {
            throw new InvalidReferenceException($value);
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function equals(self $reference): bool
    {
        return $this->value() === $reference->value();
    }

    private function isValidFormat(string $value): bool
    {
        return preg_match('/[\d]{2}-[a-zA-Z]{8}/', $value);
    }
}