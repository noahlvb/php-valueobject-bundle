<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Tests\Unit\Implementation;

use Noahlvb\ValueObjectBundle\Presentation\Form\ValueObjectForm;

class EmailAddressForm extends ValueObjectForm
{
    protected function getClassName(): string
    {
        return EmailAddress::class;
    }
}
