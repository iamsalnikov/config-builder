<?php

namespace iamsalnikov\ConfigBuilder\Factories;

use iamsalnikov\ConfigBuilder\Interfaces\PlaceholderProcessor;

/**
 * Class PlaceholderProcessorFactory
 *
 * @package iamsalnikov\ConfigBuilder\Factories
 */
class PlaceholderProcessorFactory extends ObjectFactory
{
    /**
     * @inheritdoc
     *
     * @return PlaceholderProcessor
     */
    public static function newObject($config)
    {
        $object = static::createFromConfig($config);

        if ($object instanceof PlaceholderProcessor) {
            return $object;
        }

        throw new FactoryException('Placeholder processor should implement ' . PlaceholderProcessor::class . ' interface');
    }
}