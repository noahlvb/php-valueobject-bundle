# php-valueobject-bundle
Symfony intergation for my value object package

![CI](https://github.com/noahlvb/php-valueobject-bundle/workflows/CI/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/noahlvb/php-valueobject-bundle/branch/master/graph/badge.svg)](https://codecov.io/gh/noahlvb/php-valueobject-bundle)
[![Latest Stable Version](https://poser.pugx.org/noahlvb-bundle/valueobject/v/stable)](https://packagist.org/packages/noahlvb/valueobject-bundle)
[![License](https://poser.pugx.org/noahlvb/valueobject-bundle/license)](https://packagist.org/packages/noahlvb/valueobject-bundle)

Installation
---
With [composer](http://packagist.org), add:

```bash
$ composer require noahlvb/valueobject-bundle
```

Run Tests
---
To make sure everything works you can run tests:

```bash
$ make test
```

Doctrine DBAL
---
In order to store you own value object just make a new doctrine type extended by `ValueObjectType`. Also add this newly created type to your doctrine config.
```php
class EmailAddressType extends ValueObjectType
{
    public function getClassName(): string
    {
        return EmailAddress::class;
    }

    public function getName(): string
    {
        return 'email_address';
    }
}
```

```yaml
doctrine:
    dbal:
        types:
          email_address: SoulSurvivor\Integration\Doctrine\Persistence\Type\ValueEmailAddressType
```

Symfony Forms
---
If you want to use your value object in a Symfony Form you should make a new form type extending `ValueObjectForm`. And then use that formType in your own form.
```php
class EmailAddressForm extends ValueObjectForm
{
    protected function getClassName(): string
    {
        return EmailAddress::class;
    }
}
```

By default `ValueObjectForm` will be a `TextType`. If you wish to override this and make it a `EmailType` for example, override the `getParent()` method with your choose.
```php
class EmailAddressForm extends ValueObjectForm
{
    protected function getClassName(): string
    {
        return EmailAddress::class;
    }

    public function getParent()
    {
        return EmailType::class;
    }
}
```

Symfony Validator
---
By default the `ValeuObjectForm` will use the `ValueObjectConstraint(Validator)` when validating the form. This will use the build in `isValid()` method of the value objects.
If you wish to write your own validation message or extend the validator you can do so in like this.
```php
class EmailAddressConstraint extends ValueObjectConstraint
{
    public $message = 'This email address is not valid.';
}
```

```php
class EmailAddressConstraintValidator extends ValueObjectConstraintValidator
{
}
```
You have the create a empty class and extend the `ValueObjectConstraintValidator`. This is because Symfony Validator matches the constraint and its validator based on the class names.