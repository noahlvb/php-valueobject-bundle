<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class ValueObjectConstraint extends Constraint
{
    public $message = 'This value is not a valid this value object.';

    public function validatedBy()
    {
        return ValueObjectConstraintValidator::class;
    }
}
