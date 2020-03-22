<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Presentation\Form;

use Noahlvb\ValueObjectBundle\Validator\Constraint\ValueObjectConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class ValueObjectForm extends AbstractType
{
    abstract protected function getClassName(): string;

    protected function getConstraintClassName(): string
    {
        return ValueObjectConstraint::class;
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addViewTransformer(
            new ValueObjectTransformer($this->getClassName())
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $constraintClassName = $this->getConstraintClassName();

        $resolver->setDefaults([
            'constraints' => [
                new $constraintClassName(),
            ],
        ]);
    }
}
