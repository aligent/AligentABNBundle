<?php
/**
 *
 *
 * @category  Aligent
 * @package
 * @author    Adam Hall <adam.hall@aligent.com.au>
 * @copyright 2018 Aligent Consulting.
 * @license
 * @link      http://www.aligent.com.au/
 */

namespace Aligent\ABNBundle\DependencyInjection;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const ROOT_NODE = 'aligent_abn';
    const ENABLED = 'enabled';
    const ABN_REQUIRED = 'required';
    const WITH_ABN_GROUP = 'group';
    const NO_ABN_GROUP = 'no_abn_group';

    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::ROOT_NODE);
        $rootNode = $treeBuilder->getRootNode();

        SettingsBuilder::append(
            $rootNode,
            [
                self::ENABLED => ['type' => 'boolean', 'value' => true],
                self::ABN_REQUIRED => ['type' => 'boolean', 'value' => false],
                self::WITH_ABN_GROUP => ['type' => 'integer', 'value' => null],
                self::NO_ABN_GROUP => ['type' => 'integer', 'value' => null],
            ]
        );
        return $treeBuilder;
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getConfigKeyByName(string $name): string
    {
        return sprintf(self::ROOT_NODE . '%s%s', ConfigManager::SECTION_MODEL_SEPARATOR, $name);
    }
}
