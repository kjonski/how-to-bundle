<?php

namespace Kjonski\HowToBundle\Tests\DependencyInjection;

use Kjonski\HowToBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfigurationRootName()
    {
        $configuration = new Configuration();
        $treeBuilder = $configuration->getConfigTreeBuilder();
        $tree = $treeBuilder->buildTree();
        $this->assertSame(Configuration::ROOT_NAME, $tree->getName());
    }

    /**
     * @dataProvider dataTestConfiguration
     *
     * @param array $inputConfig
     * @param array $expectedConfig
     */
    public function testConfiguration(array $inputConfig, array $expectedConfig)
    {
        $configuration = new Configuration();

        $node = $configuration->getConfigTreeBuilder()
            ->buildTree();
        $normalizedConfig = $node->normalize($inputConfig);
        $finalizedConfig = $node->finalize($normalizedConfig);

        $this->assertSame($expectedConfig, $finalizedConfig);
    }

    public function dataTestConfiguration()
    {
        return [
            [
                [],
                [
                    Configuration::NODE_TEST => 'test_node_value',
                ],
            ],
            [
                [
                    Configuration::NODE_TEST => 'test_value',
                ],
                [
                    Configuration::NODE_TEST => 'test_value',
                ],
            ],
        ];
    }
}
