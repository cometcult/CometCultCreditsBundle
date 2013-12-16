<?php

namespace CometCult\CreditsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('comet_cult_credits');

        $rootNode
            ->children()
                ->integerNode('min_threshold')
                    ->defaultValue(0)
                    ->info('The minimal value to check against credit balance')
                ->end()
                ->integerNode('max_threshold')
                    ->defaultValue(100)
                    ->info('The maximal value to check against credit balance')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
