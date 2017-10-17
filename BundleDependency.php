<?php

namespace SymfonyBundles\BundleDependency;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use SymfonyBundles\BundleDependency\DependencyInjection\Compiler;

trait BundleDependency
{
    /**
     * @var bool
     */
    private $booted = false;

    /**
     * @var array
     */
    private $bundles = [];

    /**
     * @var array
     */
    private $instances = [];

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $this->registerBundleDependencies($container);
    }

    /**
     * Register the bundle dependencies.
     *
     * @param ContainerBuilder $container
     */
    protected function registerBundleDependencies(ContainerBuilder $container)
    {
        if (true === $this->booted) {
            return;
        }

        $this->bundles = $container->getParameter('kernel.bundles');

        if ($this->createBundles($this->getBundleDependencies())) {
            $container->setParameter('kernel.bundles', $this->bundles);

            $this->initializeBundles($container);

            $pass = new Compiler\ExtensionLoadPass($this->instances);

            $container->addCompilerPass($pass);
        }

        $this->booted = true;
    }

    /**
     * Creating the instances of bundle dependencies.
     *
     * @param array $dependencies
     *
     * @return bool Has new instances or not.
     */
    protected function createBundles(array $dependencies)
    {
        foreach ($dependencies as $bundleClass) {
            $name = substr($bundleClass, strrpos($bundleClass, '\\') + 1);

            if (false === isset($this->bundles[$name])) {
                $bundle = new $bundleClass();
                $this->bundles[$name] = $bundleClass;
                $this->instances[$name] = $bundle;

                if ($bundle instanceof BundleDependencyInterface) {
                    $this->createBundles($bundle->getBundleDependencies());
                }
            }
        }

        return count($this->instances) > 0;
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function initializeBundles(ContainerBuilder $container)
    {
        foreach ($this->instances as $bundle) {
            if ($extension = $bundle->getContainerExtension()) {
                $container->registerExtension($extension);
            }

            $bundle->build($container);
        }

        foreach ($this->instances as $bundle) {
            $bundle->setContainer($container);
            $bundle->boot();
        }
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getBundleDependencies();
}
