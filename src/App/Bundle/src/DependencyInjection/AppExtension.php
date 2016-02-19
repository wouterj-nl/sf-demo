<?php

namespace App\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class AppExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../resources/services'));

        $loader->load('repositories.yml');
        $loader->load('services.yml');
        $loader->load('command_handlers.yml');
    }
}
