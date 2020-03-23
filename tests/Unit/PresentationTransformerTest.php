<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Tests\Unit;

use Noahlvb\ValueObjectBundle\Presentation\Form\ValueObjectTransformer;
use Noahlvb\ValueObjectBundle\Tests\Unit\Implementation\EmailAddress;
use PHPUnit\Framework\TestCase;

class PresentationTransformerTest extends TestCase
{
    private const EMAIL_ADDRESS_VALID = 'mail@noahlvb.nl';
    private const EMPTY = '';

    /**
     * @test
     */
    public function testTransformValueObject(): void
    {
        $valueObjectTransformer = new ValueObjectTransformer(EmailAddress::class);
        $emailAddress = new EmailAddress(self::EMAIL_ADDRESS_VALID);

        $emailAddressString = $valueObjectTransformer->transform($emailAddress);

        static::assertSame(self::EMAIL_ADDRESS_VALID, $emailAddressString);
    }

    /**
     * @test
     */
    public function testTransformString(): void
    {
        $valueObjectTransformer = new ValueObjectTransformer(EmailAddress::class);

        $emailAddressString = $valueObjectTransformer->transform(self::EMAIL_ADDRESS_VALID);

        static::assertSame(self::EMAIL_ADDRESS_VALID, $emailAddressString);
    }

    /**
     * @test
     */
    public function testTransformNull(): void
    {
        $valueObjectTransformer = new ValueObjectTransformer(EmailAddress::class);

        $emailAddressString = $valueObjectTransformer->transform(null);

        static::assertSame(self::EMPTY, $emailAddressString);
    }

    /**
     * @test
     */
    public function testReverseTransformValid(): void
    {
        $valueObjectTransformer = new ValueObjectTransformer(EmailAddress::class);

        /** @var EmailAddress $emailAddress */
        $emailAddress = $valueObjectTransformer->reverseTransform(self::EMAIL_ADDRESS_VALID);

        static::assertSame(self::EMAIL_ADDRESS_VALID, $emailAddress->getValue());
    }

    /**
     * @test
     */
    public function testReverseTransformEmpty(): void
    {
        $valueObjectTransformer = new ValueObjectTransformer(EmailAddress::class);

        /** @var EmailAddress $emailAddress */
        $emailAddressOrNull = $valueObjectTransformer->reverseTransform(self::EMPTY);

        static::assertNull($emailAddressOrNull);
    }
}
