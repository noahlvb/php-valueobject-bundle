<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Presentation\Form;

use Symfony\Component\Form\DataTransformerInterface;

class ValueObjectTransformer implements DataTransformerInterface
{
    /**
     * @var string
     */
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function transform($value)
    {
        if ($value === null) {
            return '';
        }

        if (is_string($value) || is_integer($value)) {
            return $value;
        }

        return $value->getValue();
    }

    public function reverseTransform($value)
    {
        if (empty($value)) {
            return null;
        }

        return new $this->className($value, false);
    }
}
