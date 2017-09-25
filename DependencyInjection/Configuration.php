<?php

namespace Lopatinas\TinkoffPaymentBundle\DependencyInjection;

use Lopatinas\TinkoffPaymentBundle\Entity\Item;
use Lopatinas\TinkoffPaymentBundle\Entity\Receipt;
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
                    ->defaultValue('https://securepay.tinkoff.ru/v2/')
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
            ->scalarNode('default_taxation')
                ->defaultValue('usn_income_outcome')
                ->validate()
                    ->ifNotInArray(Receipt::$taxationList)
                    ->thenInvalid('Wrong Taxation value. Possible values: ' . implode(', ', Receipt::$taxationList))
                ->end()
            ->end()
            ->scalarNode('default_tax')
                ->defaultValue('vat18')
                ->validate()
                    ->ifNotInArray(Item::$taxesList)
                    ->thenInvalid('Wrong Tax value. Possible values: ' . implode(', ', Item::$taxesList))
                ->end()
            ->end()
        ;
    }
}
