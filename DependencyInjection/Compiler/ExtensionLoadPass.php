<?php

namespace SymfonyBundles\BundleDependency\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class ExtensionLoadPass implements CompilerPassInterface
{
    /**
     * @var array
     */
    private $bundles;

    /**
     * @param array $bundles
     */
    public function __construct(array $bundles)
    {
        $this->bundles = $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($this->bundles as $bundle) {
            if ($extension = $bundle->getContainerExtension()) {
                $this->loadExtension($extension, $container);
            }
        }
    }

    /**
     * @param Extension        $extension
     * @param ContainerBuilder $container
     */
    private function loadExtension(Extension $extension, ContainerBuilder $container)
    {
        if (!$container->getExtensionConfig($extension->getAlias())) {
            $extension->load([], $container);
        }
    }
}
