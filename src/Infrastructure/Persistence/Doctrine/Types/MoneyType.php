<?php


namespace App\Infrastructure\Persistence\Doctrine\Types;

use App\Application\Transform\MoneyTransform;
use Doctrine\DBAL\Types\JsonType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class MoneyType extends JsonType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $moneyTransform = new MoneyTransform();
        $data = $moneyTransform->toArray($value);
        return parent::convertToDatabaseValue($data, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);
        $moneyTransform = new MoneyTransform();
        return $moneyTransform->fromArray($value);
    }

    public function getName(): string
    {
        return 'money';
    }
}