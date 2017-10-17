<?php

namespace SymfonyBundles\BundleDependency\Tests;

use SymfonyBundles\BundleDependency\BundleDependency;

class TraitTest extends TestCase
{
    use BundleDependency;

    public function testGetBundleDependencies()
    {
        $this->assertCount(1, $this->getBundleDependencies());
    }

    public function getBundleDependencies()
    {
        return [
            Bundle\FirstBundle\FirstBundle::class,
        ];
    }
}
