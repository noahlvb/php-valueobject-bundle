<?php

declare(strict_types=1);

namespace Noahlvb\ValueObjectBundle\Tests\Unit;

use Noahlvb\ValueObjectBundle\Tests\Unit\Implementation\EmailAddressForm;
use Noahlvb\ValueObjectBundle\Validator\Constraint\ValueObjectConstraint;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\FormIntegrationTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresentationFormTest extends FormIntegrationTestCase
{
    private const VALUE_OBJECT_CONSTRAINT_MESSAGE = 'This value is not a valid this value object.';

    /**
     * @var FormBuilder
     */
    protected $builder;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dispatcher = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();
        $this->builder = new FormBuilder('', null, $this->dispatcher, $this->factory);
    }

    /**
     * @test
     */
    public function testBuildForm(): void
    {
        $emailAddressForm = new EmailAddressForm();

        $emailAddressForm->buildForm($this->builder, []);

        static::assertTrue(true);
    }

    public function testConfigureOptions(): void
    {
        $emailAddressForm = new EmailAddressForm();
        $optionsResolver = new OptionsResolver();

        $emailAddressForm->configureOptions($optionsResolver);

        /** @var ValueObjectConstraint $valueObjectConstraintOption */
        $valueObjectConstraintOption = $optionsResolver->resolve()['constraints'][0];

        static::assertInstanceOf(ValueObjectConstraint::class, $valueObjectConstraintOption);
        static::assertSame(self::VALUE_OBJECT_CONSTRAINT_MESSAGE, $valueObjectConstraintOption->message);
    }
}
