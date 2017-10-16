<?php

namespace SymfonyBundles\BundleDependency\Tests\Bundle\FirstBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonyBundles\BundleDependency\BundleDependency;
use SymfonyBundles\BundleDependency\BundleDependencyInterface;

class FirstBundle extends Bundle implements BundleDependencyInterface
{
    use BundleDependency;

    public function getBundleDependencies()
    {
        return [
            \SymfonyBundles\BundleDependency\Tests\Bundle\SecondBundle\SecondBundle::class,
            \SymfonyBundles\BundleDependency\Tests\Bundle\ThirdBundle\ThirdBundle::class,
        ];
    }
}
