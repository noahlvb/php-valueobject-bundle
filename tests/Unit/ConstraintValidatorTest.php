<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle;

use Noahlvb\ValueObjectBundle\Tests\Unit\Implementation\EmailAddress;
use Noahlvb\ValueObjectBundle\Tests\Unit\Implementation\NonValueObject;
use Noahlvb\ValueObjectBundle\Validator\Constraint\ValueObjectConstraint;
use Noahlvb\ValueObjectBundle\Validator\Constraint\ValueObjectConstraintValidator;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ConstraintValidatorTest extends ConstraintValidatorTestCase
{
    private const EMAIL_ADDRESS_VALID = 'mail@noahlvb.nl';
    private const EMAIL_ADDRESS_INVALID = 'mail@test@noahlvb.nl';
    private const VALUE_OBJECT_CONSTRAINT_MESSAGE = 'This value is not a valid this value object.';

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new ValueObjectConstraintValidator();
    }

    /**
     * @test
     */
    public function testValidateWrongConstraint(): void
    {
        $positiveConstraint = new Positive();
        $emailAddress = new EmailAddress(self::EMAIL_ADDRESS_VALID);

        static::expectExceptionMessage('Expected argument of type "Noahlvb\ValueObjectBundle\Validator\Constraint\ValueObjectConstraint", "Symfony\Component\Validator\Constraints\Positive" given');
        $this->validator->validate($emailAddress, $positiveConstraint);
    }

    /**
     * @test
     */
    public function testValidateNull(): void
    {
        $valueObjectConstraint = new ValueObjectConstraint();

        $this->validator->validate(null, $valueObjectConstraint);

        static::assertNoViolation();
    }

    /**
     * @test
     */
    public function testValidateNonValueObject(): void
    {
        $valueObjectConstraint = new ValueObjectConstraint();
        $nonValueObject = new NonValueObject();

        $this->validator->validate($nonValueObject, $valueObjectConstraint);

        static::assertNoViolation();
    }

    /**
     * @test
     */
    public function testValidateValid(): void
    {
        $valueObjectConstraint = new ValueObjectConstraint();
        $emailAddress = new EmailAddress(self::EMAIL_ADDRESS_VALID);

        $this->validator->validate($emailAddress, $valueObjectConstraint);

        static::assertNoViolation();
    }

    /**
     * @test
     */
    public function testValidateInvalid(): void
    {
        $valueObjectConstraint = new ValueObjectConstraint();
        $emailAddress = new EmailAddress(self::EMAIL_ADDRESS_INVALID, false);

        $this->validator->validate($emailAddress, $valueObjectConstraint);

        static::assertSame(self::VALUE_OBJECT_CONSTRAINT_MESSAGE, $this->context->getViolations()->get(0)->getMessage());
    }
}
