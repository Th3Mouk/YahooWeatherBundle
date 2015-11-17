<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('th3mouk_yahoo_weather');

        $rootNode
            ->children()
                ->arrayNode('templates')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('today')->defaultValue('Th3MoukYahooWeatherBundle:Default:today.html.twig')->end()
                        ->scalarNode('forecast')->defaultValue('Th3MoukYahooWeatherBundle:Default:forecast.html.twig')->end()
                    ->end()
                ->end()
                ->arrayNode('pictograms')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('helper')->end()
                        ->scalarNode('extension')->defaultValue('Th3Mouk\YahooWeatherBundle\Twig\PictoExtension')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
