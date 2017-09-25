<?php

namespace Lopatinas\TinkoffPaymentBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class TinkoffPaymentExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('tinkoff_payment.api_url', $config['api_url']);
        $container->setParameter('tinkoff_payment.terminal_key', $config['terminal_key']);
        $container->setParameter('tinkoff_payment.secret_key', $config['secret_key']);
        $container->setParameter('tinkoff_payment.default_taxation', $config['default_taxation']);
        $container->setParameter('tinkoff_payment.default_tax', $config['default_tax']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
