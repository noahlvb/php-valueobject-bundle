<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Validator\Constraint;

use Noahlvb\ValueObject\ValueObjectInteger;
use Noahlvb\ValueObject\ValueObjectString;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ValueObjectConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ValueObjectConstraint) {
            throw new UnexpectedTypeException($constraint, ValueObjectConstraint::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!($value instanceof ValueObjectString || $value instanceof ValueObjectInteger)) {
            return;
        }

        if (!$value->isValid($value->getValue())) {
            $this->context->buildViolation($constraint->message)->addViolation();

            return;
        }
    }
}
