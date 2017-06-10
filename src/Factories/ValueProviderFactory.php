<?php

namespace iamsalnikov\ConfigBuilder\Factories;

use iamsalnikov\ConfigBuilder\Interfaces\ValueProvider;

/**
 * Class ValueProviderFactory
 *
 * @package iamsalnikov\ConfigBuilder\Factories
 */
class ValueProviderFactory extends ObjectFactory
{
    /**
     * @inheritdoc
     *
     * @return ValueProvider
     */
    public static function newObject($config)
    {
        $object = static::createFromConfig($config);

        if ($object instanceof ValueProvider) {
            return $object;
        }

        throw new FactoryException('Value provider should implement ' . ValueProvider::class . ' interface');
    }
}