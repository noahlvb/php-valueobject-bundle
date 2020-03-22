<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Tests\Unit\Implementation;

use Noahlvb\ValueObjectBundle\Persistence\Type\ValueObjectType;

class CapacityType extends ValueObjectType
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'capacity';
    }

    public function getClassName(): string
    {
        return Capacity::class;
    }
}
