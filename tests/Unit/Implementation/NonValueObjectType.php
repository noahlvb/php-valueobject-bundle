<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Tests\Unit\Implementation;

use Noahlvb\ValueObjectBundle\Persistence\Type\ValueObjectType;

class NonValueObjectType extends ValueObjectType
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'non_value_object';
    }

    public function getClassName(): string
    {
        return NonValueObject::class;
    }
}
