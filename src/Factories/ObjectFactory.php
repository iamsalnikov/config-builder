<?php

namespace iamsalnikov\ConfigBuilder\Factories;

/**
 * Class ObjectFactory
 *
 * @package iamsalnikov\ConfigBuilder\Factories
 */
abstract class ObjectFactory
{
    /**
     * Create object from config
     *
     * @param array $config
     * @return object
     * @throws FactoryException
     */
    protected static function createFromConfig($config)
    {
        static::validateConfig($config);

        if (!array_key_exists('arguments', $config)) {
            $config['arguments'] = [];
        }

        $reflect = new \ReflectionClass($config['class']);
        return $reflect->newInstanceArgs($config['arguments']);
    }

    /**
     * Validate config
     *
     * @param $config
     * @throws FactoryException
     */
    protected static function validateConfig($config)
    {
        if (!is_array($config)) {
            throw new FactoryException('Config should be array');
        }

        if (!array_key_exists('class', $config)) {
            throw new FactoryException('Config should have class');
        }
    }
}