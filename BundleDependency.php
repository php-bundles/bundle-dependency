<?php

namespace SymfonyBundles\BundleDependency;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\MergeExtensionConfigurationPass;

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
     *
     * @return void
     */
    protected function registerBundleDependencies(ContainerBuilder $container)
    {
        if (true === $this->booted) {
            return;
        }

        $this->bundles = $container->getParameter('kernel.bundles');

        $this->createBundles($this->getBundleDependencies());

        $container->setParameter('kernel.bundles', $this->bundles);

        $this->initializeBundles($container);

        $this->booted = true;
    }

    /**
     * Creating the instances of bundle dependencies.
     *
     * @param array $dependencies
     *
     * @return void
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
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return void
     */
    protected function initializeBundles(ContainerBuilder $container)
    {
        $extensions = [];

        foreach ($this->instances as $bundle) {
            if ($extension = $bundle->getContainerExtension()) {
                $container->registerExtension($bundle->getContainerExtension());
                $extensions[] = $extension->getAlias();
            }

            $bundle->build($container);
        }

        $container->getCompilerPassConfig()->setMergePass(new MergeExtensionConfigurationPass($extensions));

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
