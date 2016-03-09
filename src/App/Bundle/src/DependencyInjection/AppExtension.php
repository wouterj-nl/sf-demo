<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AppExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        // The resources are seperated from the PHP code, so the
        // value passed to FileLocator is a bit different than
        // you're probably used to.
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../resources/services'));

        $loader->load('repositories.yml');
        $loader->load('services.yml');
        $loader->load('command_handlers.yml');
    }
}
