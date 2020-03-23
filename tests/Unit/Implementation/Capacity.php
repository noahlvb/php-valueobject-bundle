<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Tests\Unit\Implementation;

use Noahlvb\ValueObject\ValueObjectInteger;

class Capacity extends ValueObjectInteger
{
    public function isValid(int $value): bool
    {
        return $value <= 255;
    }
}
