<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class Th3MoukYahooWeatherExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('th3mouk.weather.templates', $config['templates']);

        if (isset($config['pictograms']['helper'])) {
            $definition = new Definition($config['pictograms']['helper']);
            $definition->setPublic(false);

            $container->setDefinition('th3mouk_yahoo_weather.pictograms.helper', $definition);

            $definition = new Definition($config['pictograms']['extension']);
            $definition->setPublic(false);
            $definition->addArgument(new Reference('th3mouk_yahoo_weather.pictograms.helper'));
            $definition->addTag('twig.extension');

            $container->setDefinition('th3mouk_yahoo_weather.pictograms.extension', $definition);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('services_admin.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'th3mouk_yahoo_weather';
    }
}
