<?php

namespace iamsalnikov\ConfigBuilder\Utils;

class File
{
    /**
     * Check if path is absolute
     *
     * @param $path
     * @return bool
     */
    public static function isAbsolutePath($path)
    {
        return strpos($path, '/') === 0;
    }

    /**
     * Get absolute path for current user directory
     *
     * @param $path
     * @return string
     */
    public static function getUserAbsolutePath($path)
    {
        if (static::isAbsolutePath($path)) {
            return $path;
        }

        return getcwd() . '/' . $path;
    }
}