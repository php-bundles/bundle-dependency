Symfony BundleDependency Component
==================================

[![SensioLabsInsight][sensiolabs-insight-image]][sensiolabs-insight-link]

[![Build Status][testing-image]][testing-link]
[![Scrutinizer Code Quality][scrutinizer-code-quality-image]][scrutinizer-code-quality-link]
[![Code Coverage][code-coverage-image]][code-coverage-link]
[![Total Downloads][downloads-image]][package-link]
[![Latest Stable Version][stable-image]][package-link]
[![License][license-image]][license-link]

Installation
------------
Pretty simple with Composer, run:

``` bash
composer require symfony-bundles/bundle-dependency
```

How to use
----------
* Add to your composer.json the bundle dependencies
* Update your composer dependencies with command `composer update`
* Modify your Bundle Class. For example:

``` php
use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonyBundles\BundleDependency\BundleDependency;
use SymfonyBundles\BundleDependency\BundleDependencyInterface;

class MyBundle extends Bundle implements BundleDependencyInterface
{
    use BundleDependency;

    public function getBundleDependencies()
    {
        return [
            'FOS\RestBundle\FOSRestBundle',
            'SymfonyBundles\ForkBundle\SymfonyBundlesForkBundle',
            'SymfonyBundles\RedisBundle\SymfonyBundlesRedisBundle',
        ];
    }
}
```

If you want override a method `build`, call the method `registerBundleDependencies`. For example:

``` php
public function build(ContainerBuilder $container)
{
    parent::build($container);
    // ...

    $this->registerBundleDependencies($container);
}
```

[package-link]: https://packagist.org/packages/symfony-bundles/bundle-dependency
[license-link]: https://github.com/symfony-bundles/bundle-dependency/blob/master/LICENSE
[license-image]: https://poser.pugx.org/symfony-bundles/bundle-dependency/license
[testing-link]: https://travis-ci.org/symfony-bundles/bundle-dependency
[testing-image]: https://travis-ci.org/symfony-bundles/bundle-dependency.svg?branch=master
[stable-image]: https://poser.pugx.org/symfony-bundles/bundle-dependency/v/stable
[downloads-image]: https://poser.pugx.org/symfony-bundles/bundle-dependency/downloads
[sensiolabs-insight-link]: https://insight.sensiolabs.com/projects/f3d1e9cc-8a94-4d0c-97c4-a488490e4f72
[sensiolabs-insight-image]: https://insight.sensiolabs.com/projects/f3d1e9cc-8a94-4d0c-97c4-a488490e4f72/big.png
[code-coverage-link]: https://scrutinizer-ci.com/g/symfony-bundles/bundle-dependency/?branch=master
[code-coverage-image]: https://scrutinizer-ci.com/g/symfony-bundles/bundle-dependency/badges/coverage.png?b=master
[scrutinizer-code-quality-link]: https://scrutinizer-ci.com/g/symfony-bundles/bundle-dependency/?branch=master
[scrutinizer-code-quality-image]: https://scrutinizer-ci.com/g/symfony-bundles/bundle-dependency/badges/quality-score.png?b=master
