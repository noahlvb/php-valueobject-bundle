<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Persistence\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Exception;
use Noahlvb\ValueObject\ValueObject;
use Noahlvb\ValueObject\ValueObjectInteger;
use Noahlvb\ValueObject\ValueObjectString;
use Noahlvb\ValueObjectBundle\Persistence\Exception\ValueObjectIsNotSafeToPersistException;

abstract class ValueObjectType extends Type
{
    abstract public function getClassName(): string;

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $className = $this->getClassName();

        if (is_subclass_of($className, ValueObjectString::class)) {
            return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
        }

        if (is_subclass_of($className, ValueObjectInteger::class)) {
            return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
        }

        throw new Exception('Type ' . $this->getClassName() . ' is not supported');
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === 'NULL') {
            return null;
        }

        if (is_numeric($value)) {
            $value = (int) $value;
        }

        $className = $this->getClassName();

        return new $className($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if (is_string($value) || is_integer($value)) {
            return $value;
        }

        /** @var ValueObject $value */
        if (!$value->isValid($value->getValue())) {
            throw new ValueObjectIsNotSafeToPersistException();
        }

        return $value->getValue();
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
