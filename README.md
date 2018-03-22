[![Build Status](https://travis-ci.org/kjonski/how-to-bundle.svg?branch=master)](https://travis-ci.org/kjonski/how-to-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kjonski/how-to-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kjonski/how-to-bundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/kjonski/how-to-bundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/kjonski/how-to-bundle/?branch=master)

# how-to-bundle
Step-by-step tutorial how to prepare Symfony bundle

## Prepare repository
Prepare bundle repository in the way you like. You can use Github or local repository.
Be advised that repository need to be accessible by your future project.   
With Github wizard you can add README.md and LICENSE  
![Github repository wizard](../master/src/Resources/images/github_repository_wizard.png "Github repository wizard")

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

## Configure project's repository
If you want develop bundle inside existing project and unless bundle isn't in [packagist.org](https://packagist.org/) please configure main project's `composer.json`.
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
        "url": "/path/to/how-to-bundle.git"
    }
],
```
when using local repository. For more details @see [Composer documentation](https://getcomposer.org/doc/05-repositories.md#loading-a-package-from-a-vcs-repository).

## Install you bundle with composer
```console
$ composer require kjonski/how-to-bundle
```

## Prepare structure
`b$` means vendor/yourVendorName/yourBundle (`vendor/kjonski/how-to-bundle`) directory.
```console
b$ mkdir src
b$ mkdir tests
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
b$ composer require symfony/dependency-injection
b$ composer require --dev symfony/http-kernel
b$ composer require --dev phpunit/phpunit
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
b$ vendor/bin/phpunit tests
```

At any point of time from now you can:
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
b$ composer install
```
to install your dev dependencies.

## Add tests configuration (`tests/phpunit.xml`)
```xml
<?xml version="1.0" encoding="UTF-8"?>

<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/7.0/phpunit.xsd"
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

  * You can see KERNEL_CLASS configured because for some cases you will need own [kernel](../master/tests/App/AppKernel.php) for phpunit.  
  * Please add `tests/coverage.xml` to ignored files.  

Now you are ready to run your test suite:
```console
b$ vendor/bin/phpunit -c tests/phpunit.xml
```

## Time for code quality tools
Install:
```console
b$ composer require --dev phpstan/phpstan
b$ composer require --dev sebastian/phpcpd
b$ composer require --dev squizlabs/php_codesniffer
b$ composer require --dev friendsofphp/php-cs-fixer
```
add [php-cs-fixer.config.php](../master/tests/php-cs-fixer.config.php), [phpstan.neon](../master/tests/phpstan.neon) (optional) and run:
```console
b$ vendor/bin/php-cs-fixer fix --config=tests/php-cs-fixer.config.php --dry-run --diff src tests
b$ vendor/bin/phpcs --report-full --standard=PSR2 src tests
b$ vendor/bin/phpstan analyse --level=4 src -c tests/phpstan.neon
b$ phpdbg -qrr vendor/bin/phpunit -c tests/phpunit.xml
```

## Build? Oh, yes!
  * Go to <https://docs.travis-ci.com/user/getting-started/> and follow instruction to enable Travis builds for your (Github) repository.
  * Add simple [.travis.yml](../master/.travis.yml) or follow [Symfony Continuous Integration](http://symfony.com/doc/current/bundles/best_practices.html#continuous-integration).  
  From now build will be run on every push to your repository.
  * Now you can go to your Travis profile -> your repository, grab your build badge and add to `README.md`  
  ![Build badge](../master/src/Resources/images/travis_ci_build_badge.png "Travis build bagde")
  
## More badges?
  * Go to <https://scrutinizer-ci.com/> and Sign Up with Github
  * Add repository
  * Update configuration
  ```yaml
build:
    nodes:
        analysis:
            ...
            tests:
                override:
                    ...
                    -
                        command: vendor/bin/phpunit -c tests/phpunit.xml
                        coverage:
                            file: 'tests/coverage.xml'
                            format: 'clover'
...                                                    
```
to enable code coverage.
  * Run inspection
  * Get badges from summary screen  
  ![Build badge](../master/src/Resources/images/scrutinizer_summary.png "Scrutinizer bagdes")
   
## Go live with packagist
  * Go to <https://packagist.org> and submit your bundle
  * Configure [GitHub Service Hook](https://packagist.org/about#how-to-update-packages) to keep your package up to date
  * Remember to remove your local/Github repository from project's `composer.json` repositories section

Sources
------
<https://getcomposer.org/doc/05-repositories.md#loading-a-package-from-a-vcs-repository>  
<https://symfony.com/doc/current/bundles.html#creating-a-bundle>  
<https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet>

