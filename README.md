CometCultCreditsBundle
======================

[![Build Status](https://travis-ci.org/cometcult/CometCultCreditsBundle.png?branch=master)](https://travis-ci.org/cometcult/CometCultCreditsBundle)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/cometcult/CometCultCreditsBundle/badges/quality-score.png?s=21840747a37218407d58828101172118410dc186)](https://scrutinizer-ci.com/g/cometcult/CometCultCreditsBundle/)

Symfony 2 Bundle for storing user credits/points

Currently supports only Doctrine MongoDB

Installation
------------

### Composer ###

Just add to your composer.json file:

```json
{
    "require": {
        "cometcult/credit-bundle": "dev-master"
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
$creditsManager->addCredit(100, 'abc123');
$creditsManager->subtractCredit(42, 'abc123');
```

You can always check the balance of a user with the BalanceChecker

```php
$creditBalanceChecker = $this->get('comet_cult_credits.balance_checker');
$creditBalanceChecker->getCreditBalance('abc123');
```

Or check against a configurable threshold. By default the minimum threshold is 0 and maximum threshold is 100

```php
$creditBalanceChecker->hasLowCreditBalance('abc123');
```

Configuration
-------------

You can configure your own threshold values. To do that just add to your Symfony config:
```yml
comet_cult_credit:
	min_threshold: 0 # min value of your choice
	max_threshold: 100 # max value of your choice
```