<?php

namespace App\Infrastructure\Persistence\Doctrine\Types;

use App\Domain\ValueObject\Reference;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class ReferenceType extends StringType
{
    public function getName(): string
    {
        return 'reference';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue((string) $value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);
        if (null === $value) {
            return null;
        }

        return new Reference($value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
