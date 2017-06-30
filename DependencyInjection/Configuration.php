<?php

namespace Lopatinas\TinkoffPaymentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $tb = new TreeBuilder();
        $root = $tb->root('tinkoff_payment');

        $this->addGeneralSection($root);

        return $tb;
    }

    protected function addGeneralSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('terminal_key')
                    ->isRequired()
                ->end()
                ->scalarNode('secret_key')
                    ->isRequired()
                ->end()
                ->scalarNode('api_url')
                    ->defaultValue('https://securepay.tinkoff.ru/rest/')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) {
                            return strtolower($v);
                        })
                    ->end()
                    ->validate()
                        ->ifTrue(function ($url) {
                            return !preg_match('/(https:\/\/(\S*?\.\S*?)\/)([\s)\[\]{},;"\':<]|\.\s|$)/i', $url);
                        })
                        ->thenInvalid('API URL "%s" is not valid.')
                    ->end()
                ->end()
        ;
    }
}
