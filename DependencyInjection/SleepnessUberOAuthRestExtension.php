<?php

namespace Sleepness\UberOAuthRestBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

use Symfony\Component\Config\FileLocator;

class SleepnessUberOAuthRestExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('guzzle.xml');
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $providers = $config['providers'];

        foreach ($providers as $name => $credentials) {
            $credentials['provider_name'] = $name;

            $class = $container->getParameter(sprintf('oauth_rest.provider.%s.class', $name), $name);
            $definition = new DefinitionDecorator('oauth_rest.provider.base');
            $definition->setClass($class);
            $definition->addMethodCall('setCredentials', [$credentials]);

            $container->setDefinition(sprintf('oauth_rest.provider.%s', $name), $definition);
        }
    }

    public function getAlias()
    {
        return 'oauth_rest';
    }
}
