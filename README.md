CometCultCreditsBundle
======================

Symfony 2 Bundle for storing user credits/points

Currently supports only Doctrine MongoDB

Installation
------------

### Composer ###

Just add to your composer.json file:

```json
{
    "require": {
        "cometcult/credits-bundle": "dev-master"
    }
}
```

### Application Kernel ###

Add the bundle to your application's kernel:
```php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new CometCult\CreditsBundle\CometCultCreditsBundle(),
        // ...
    );
}
```

Usage
-----

CometCultCreditsBundle should be operated from CreditsManager

Create credit instance

```php
$creditsManager = $this->get('comet_cult_credits.manager');
$credit = $creditsManager->createCredit(200, 'abc123');
```

Then persist credit instance with updateCredit() method

```php
$creditsManager->updateCredit($credit);
```

Basic operations should be performed providing {ownerId} and amount of credit if needed

```php
$creditsManager->getCreditBalance('abc123');
$creditsManager->addCredit(100, 'abc123');
```
