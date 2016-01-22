<?php

namespace MB\DashboardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mb_dashboard');

        $rootNode
            ->children()
                ->arrayNode('connections')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->enumNode('type')
                                ->values(array('github', 'gitlab', 'gitlabci', 'stash', 'bamboo'))
                                ->isRequired()
                            ->end()
                            ->scalarNode('host')
                                ->cannotBeEmpty()
                                ->isRequired()
                            ->end()
                            ->scalarNode('api_token')
                                ->defaultNull()
                            ->end()
                            ->scalarNode('api_password')
                                ->defaultNull()
                            ->end()
                            ->scalarNode('api_username')
                                ->defaultNull()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
