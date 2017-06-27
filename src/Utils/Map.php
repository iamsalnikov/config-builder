<?php

namespace iamsalnikov\ConfigBuilder\Utils;

use iamsalnikov\ConfigBuilder\Values\Nil;

/**
 * Class Map
 * @package iamsalnikov\ConfigBuilder\Utils
 */
class Map
{
    /**
     * Get value
     *
     * @param string $key 'hello', 'hello.1', 'hello.test'
     * @param array $map
     * @return mixed
     */
    public static function getValue($key, $map)
    {
        if (!is_array($map)) {
            return new Nil();
        }

        $keyParts = explode('.', $key, 2);
        $rootKey = $keyParts[0];

        if (!array_key_exists($rootKey, $map)) {
            return new Nil();
        }

        return isset($keyParts[1])
            ? static::getValue($keyParts[1], $map[$rootKey])
            : $map[$rootKey];
    }
}
