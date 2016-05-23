<?php

namespace SymfonyBundles\BundleDependency\Tests\Bundle\ThirdBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonyBundles\BundleDependency\BundleDependency;
use SymfonyBundles\BundleDependency\BundleDependencyInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ThirdBundle extends Bundle implements BundleDependencyInterface
{

    use BundleDependency;

    public function build(ContainerBuilder $container)
    {
        $this->registerBundleDependencies($container);
        $this->registerBundleDependencies($container);
    }

    public function getContainerExtension()
    {
        return new DependencyInjection\ThirdExtension();
    }

    public function getBundleDependencies()
    {
        return [
            \SymfonyBundles\BundleDependency\Tests\Bundle\FourthBundle\FourthBundle::class,
        ];
    }

}
