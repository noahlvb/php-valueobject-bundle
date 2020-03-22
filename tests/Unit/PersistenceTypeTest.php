<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Tests\Unit;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Noahlvb\ValueObjectBundle\Tests\Unit\Implementation\Capacity;
use Noahlvb\ValueObjectBundle\Tests\Unit\Implementation\CapacityType;
use Noahlvb\ValueObjectBundle\Tests\Unit\Implementation\EmailAddress;
use Noahlvb\ValueObjectBundle\Tests\Unit\Implementation\EmailAddressType;
use Noahlvb\ValueObjectBundle\Tests\Unit\Implementation\NonValueObject;
use Noahlvb\ValueObjectBundle\Tests\Unit\Implementation\NonValueObjectType;
use PHPUnit\Framework\TestCase;

class PersistenceTypeTest extends TestCase
{
    private const EMAIL_ADDRESS_SQL_DECLARATION = 'VARCHAR(255)';
    private const CAPACITY_SQL_DECLARATION = 'INT';
    private const EMAIL_ADDRESS_VALID = 'mail@noahlvb.nl';
    private const EMAIL_ADDRESS_INVALID = 'mail@test@noahlvb.nl';
    private const CAPACITY_VALID = 95;
    private const NULL = 'NULL';

    /**
     * @test
     */
    public function testGetSQLDeclarationString(): void
    {
        $emailAddressType = new EmailAddressType();
        $mysqlPlatform = new MySqlPlatform();

        $sqlDeclarationString = $emailAddressType->getSQLDeclaration([], $mysqlPlatform);

        static::assertSame(self::EMAIL_ADDRESS_SQL_DECLARATION, $sqlDeclarationString);
    }

    /**
     * @test
     */
    public function testGetSQLDeclarationInteger(): void
    {
        $capacityType = new CapacityType();
        $mysqlPlatform = new MySqlPlatform();

        $sqlDeclarationString = $capacityType->getSQLDeclaration([], $mysqlPlatform);

        static::assertSame(self::CAPACITY_SQL_DECLARATION, $sqlDeclarationString);
    }

    /**
     * @test
     */
    public function testGetSQLDeclarationNonValueObject(): void
    {
        $capacityType = new NonValueObjectType();
        $mysqlPlatform = new MySqlPlatform();

        static::expectExceptionMessage(
            'Type Noahlvb\ValueObjectBundle\Tests\Unit\Implementation\NonValueObject is not supported'
        );
        $capacityType->getSQLDeclaration([], $mysqlPlatform);
    }

    /**
     * @test
     */
    public function testConvertToPHPValueStringValid(): void
    {
        $emailAddressType = new EmailAddressType();
        $mysqlPlatform = new MySqlPlatform();

        /** @var EmailAddress $emailAddress */
        $emailAddress = $emailAddressType->convertToPHPValue(self::EMAIL_ADDRESS_VALID, $mysqlPlatform);

        static::assertTrue($emailAddress instanceof EmailAddress);
        static::assertSame(self::EMAIL_ADDRESS_VALID, $emailAddress->getValue());
    }

    /**
     * @test
     */
    public function testConvertToPHPValueIntegerValid(): void
    {
        $capacityType = new CapacityType();
        $mysqlPlatform = new MySqlPlatform();

        /** @var Capacity $capacity */
        $capacity = $capacityType->convertToPHPValue(self::CAPACITY_VALID, $mysqlPlatform);

        static::assertTrue($capacity instanceof Capacity);
        static::assertSame(self::CAPACITY_VALID, $capacity->getValue());
    }

    /**
     * @test
     */
    public function testConvertToPHPValueNull(): void
    {
        $emailAddressType = new EmailAddressType();
        $mysqlPlatform = new MySqlPlatform();

        $emailAddressOrNull = $emailAddressType->convertToPHPValue(self::NULL, $mysqlPlatform);

        static::assertNull($emailAddressOrNull);
    }

    /**
     * @test
     */
    public function testConvertToDatabaseValueValid(): void
    {
        $emailAddressType = new EmailAddressType();
        $mysqlPlatform = new MySqlPlatform();
        $emailAddress = new EmailAddress(self::EMAIL_ADDRESS_VALID);

        $databaseColumnString = $emailAddressType->convertToDatabaseValue($emailAddress, $mysqlPlatform);

        static::assertSame(self::EMAIL_ADDRESS_VALID, $databaseColumnString);
    }

    /**
     * @test
     */
    public function testConvertToDatabaseValueNull(): void
    {
        $emailAddressType = new EmailAddressType();
        $mysqlPlatform = new MySqlPlatform();

        $databaseColumnString = $emailAddressType->convertToDatabaseValue(self::EMAIL_ADDRESS_VALID, $mysqlPlatform);

        static::assertSame(self::EMAIL_ADDRESS_VALID, $databaseColumnString);
    }

    /**
     * @test
     */
    public function testConvertToDatabaseValuePrimitive(): void
    {
        $emailAddressType = new EmailAddressType();
        $mysqlPlatform = new MySqlPlatform();

        $databaseColumnString = $emailAddressType->convertToDatabaseValue(null, $mysqlPlatform);

        static::assertNull($databaseColumnString);
    }

    /**
     * @test
     */
    public function testConvertToPHPValueStringInvalid(): void
    {
        $emailAddressType = new EmailAddressType();
        $mysqlPlatform = new MySqlPlatform();
        $emailAddress = new EmailAddress(self::EMAIL_ADDRESS_INVALID, false);

        static::expectException('Noahlvb\ValueObjectBundle\Persistence\Exception\ValueObjectIsNotSafeToPersistException');
        $emailAddressType->convertToDatabaseValue($emailAddress, $mysqlPlatform);
    }

    /**
     * @test
     */
    public function testRequiresSQLCommentHint(): void
    {
        $emailAddressType = new EmailAddressType();
        $mysqlPlatform = new MySqlPlatform();

        static::assertTrue($emailAddressType->requiresSQLCommentHint($mysqlPlatform));
    }
}
