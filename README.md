# how-to-bundle
Step-by-step tutorial how to prepare Symfony bundle

## Prepare repository
Prepare bundle repository in the way you like. You can use Github or local repository.
Be advised that repository need to accessible by your future project.   
With Github wizard you can add README.md and LICENCE

## Clone repository
```bash
git clone https://github.com/kjonski/how-to-bundle.git
```
and open with editor.

## Add `composer.json` file
```yaml
{
    "name": "kjonski/how-to-bundle",
    "type": "symfony-bundle",
    "description": "Step-by-step Symfony bundle tutorial",
    "keywords": ["php", "symfony", "reusable bundle", "tutorial"],
    "license": "MIT",
    "authors": [
        {
            "name": "Karol Jonski",
            "email": "kjonski@pgs-soft.com"
        }
    ]
}
```
commit and push changes.

## Configure project repository
If you want develop bundle inside existing project and unles bundle isn't in [packagist.org](https://packagist.org/) please configure main project's `composer.json`.
Add/modify `repositories` section:
```json
"repositories": [
    {
        "type": "git",
        "url": "https://github.com/kjonski/how-to-bundle.git"
    }
],
```
when using Github repository, or:
```json
"repositories": [
    {
        "type": "git",
        "url": "/path/to/how-to-bundle.git",
    }
],
```
when using local repository. For more details @see [Composer documentation](https://getcomposer.org/doc/05-repositories.md#loading-a-package-from-a-vcs-repository).

## Install you bundle with composer
```console
$ composer require kjonski/how-to-bundle
```

## Prepare structure
```console
$ mkdir src
$ mkdir tests
```

## Configure autoloading in your `composer.json`
```json
"autoload": {
    "psr-4": { "Kjonski\\HowToBundle\\": "src/" }
},
"autoload-dev": {
    "psr-4": {
        "Kjonski\\HowToBundle\\Tests\\": "tests/"
    }
}
```

## Install dependencies
```console
$ composer require symfony/dependency-injection
$ composer require --dev symfony/http-kernel
$ composer require --dev phpunit/phpunit
```

## Add bundle class
```php
<?php
// src/KjonskiHowToBundle.php

namespace Kjonski\HowToBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;

class KjonskiHowToBundle extends Bundle
{

}
```

## Add extension class
```php
<?php
// src/DependencyInjection/KjonskiHowToExtension.php

namespace Kjonski\HowToBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class KjonskiHowToExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
    }
}
``` 

## Prepare first test
```php
<?php
// tests/KjonskiHowToBundleTest.php


namespace Kjonski\HowToBundle\Tests;


use Kjonski\HowToBundle\DependencyInjection\KjonskiHowToExtension;
use Kjonski\HowToBundle\KjonskiHowToBundle;
use PHPUnit\Framework\TestCase;

class KjonskiHowToBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $bundle = new KjonskiHowToBundle();
        $this->assertInstanceOf(KjonskiHowToExtension::class, $bundle->getContainerExtension());
    }
}
```

and run from bundle directory:
```console
$ ./vendor/bin/phpunit tests
```

At any point of time from you can:
```console
$ composer remove kjonski/how-to-bundle
```
and
```console
$ composer require kjonski/how-to-bundle
```
and your bundle will be reinstaled.  
Be advised that you need to run:
```console
...vendor/yourVendorName/yourBundle$ composer install
```
to install your dev dependencies.

## Add tests configuration (`tests/phpunit.xml`)
```xml
<?xml version="1.0" encoding="UTF-8"?>

<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.1/phpunit.xsd"
         backupGlobals='false'
         backupStaticAttributes='false'
         beStrictAboutTestsThatDoNotTestAnything='true'
         bootstrap='./../vendor/autoload.php'
         colors='true'
         convertErrorsToExceptions='true'
         convertNoticesToExceptions='true'
         convertWarningsToExceptions='true'
         stopOnError='false'
         stopOnFailure='false'
         stopOnIncomplete='false'
         stopOnSkipped='false'
         verbose='true'
>
    <php>
        <ini name="error_reporting" value="-1" />
        <env name="KERNEL_CLASS" value="\Kjonski\HowToBundle\Tests\App\AppKernel" />
        <ini name='display_errors' value='1' />
        <ini name='display_startup_errors' value='1' />
        <ini name='error_reporting' value='-1' />
        <ini name='memory_limit' value='-1' />
    </php>

    <testsuites>
        <testsuite name="How To Bundle Test Suite">
            <directory>.</directory>
        </testsuite>
    </testsuites>

    <logging>
        <log type='coverage-clover' target='coverage.xml' />
        <log type='coverage-text' target='php://stdout' showOnlySummary='true' />
    </logging>

    <filter>
        <whitelist>
            <directory>../src</directory>
            <exclude>
                <directory>../vendor</directory>
            </exclude>
        </whitelist>
    </filter>
</phpunit>
```

For some you will need own [kernel](../master/tests/App/AppKernel.php) for phpunit.  
Please add `tests/coverage.xml` to ignored files.  
Now you are ready to run your test suite:
```console
$ ./vendor/bin/phpunit -c tests/phpunit.xml
```

Sources
------
<https://getcomposer.org/doc/05-repositories.md#loading-a-package-from-a-vcs-repository>
<https://symfony.com/doc/current/bundles.html#creating-a-bundle>

