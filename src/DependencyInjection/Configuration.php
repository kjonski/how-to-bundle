<?php

namespace Kjonski\HowToBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const ROOT_NAME = 'kjonski_how_to';

    const NODE_TEST = 'test_node';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(self::ROOT_NAME);
        $rootNode
            ->children()
                ->scalarNode(self::NODE_TEST)->defaultValue('test_node_value')->end()
            ->end();

        return $treeBuilder;
    }
}
