<?php

namespace SymfonyBundles\BundleDependency;

interface BundleDependencyInterface
{
    /**
     * Gets the list of bundle dependencies.
     *
     * @return array
     */
    public function getBundleDependencies();
}
