<?php

namespace iamsalnikov\ConfigBuilder\Utils;

class Map
{
    /**
     * Get value
     *
     * @param $key
     * @param $map
     * @return mixed
     */
    public static function getValue($key, $map)
    {
        if (!is_array($map)) {
            return null;
        }

        $keyParts = explode('.', $key, 2);
        $rootKey = $keyParts[0];

        if (!array_key_exists($rootKey, $map)) {
            return null;
        }

        return isset($keyParts[1])
            ? static::getValue($keyParts[1], $map[$rootKey])
            : $map[$rootKey];
    }
}