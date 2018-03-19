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