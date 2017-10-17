<?php

namespace SymfonyBundles\BundleDependency\Tests;

class BundleTest extends TestCase
{
    public function testBundleExists()
    {
        $bundles = $this->container->getParameter('kernel.bundles');

        $this->assertArrayHasKey('FirstBundle', $bundles);
        $this->assertArrayHasKey('SecondBundle', $bundles);
        $this->assertArrayHasKey('ThirdBundle', $bundles);
        $this->assertArrayHasKey('FourthBundle', $bundles);
    }
}
