<?php

namespace Sleepness\UberOAuthRestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('oauth_rest');

        $rootNode
            ->children()
                ->arrayNode('providers')
                    ->requiresAtLeastOneElement()
                    ->validate()
                        ->ifTrue(function ($providers) {
                            return count(array_diff(array_keys($providers), ['fb', 'gp', 'vk'])) > 0;
                        })
                        ->thenInvalid('Providers must be either \'fb\' or \'gp\' or \'vk\'.')
                    ->end()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('client_id')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('client_secret')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('redirect_uri')->isRequired()->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
