<?php

namespace Uber\OAuthRestBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

use Symfony\Component\Config\FileLocator;

class OAuthRestExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $providers = $config['providers'];

        foreach ($providers as $name => $credentials) {
            $class = $container->getParameter(sprintf('oauth_rest.provider.%s.class'), $name);
            $definition = new Definition($class);
            $definition->setProperty('parent', 'oauth_rest.provider.base');
            $definition->addMethodCall('setCredentials', [$credentials]);

            $container->addDefinition(sprintf('oauth_rest.provider.%s', $name), $definition);
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('guzzle.xml');
        $loader->load('services.xml');
    }

    public function getAlias()
    {
        return 'oauth_rest';
    }
}
