<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Tests\Unit\Implementation;

use Noahlvb\ValueObject\ValueObjectString;

class EmailAddress extends ValueObjectString
{
    protected function sanitize(string $value): string
    {
        return trim(strtolower($value));
    }

    public function isValid(string $value): bool
    {
        return is_string(filter_var($value, FILTER_VALIDATE_EMAIL));
    }
}
