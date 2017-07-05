<?php

namespace iamsalnikov\ConfigBuilder\Utils;

class File
{
    /**
     * @var null|string config directory path
     */
    private static $configDirectory = null;

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

    /**
     * Set config directory path
     *
     * @param $path
     * @throws Exception
     */
    public static function setConfigDirectory($path)
    {
        if (!is_dir($path)) {
            throw new Exception('Config directory should be path of directory');
        }

        static::$configDirectory = '/' . trim($path, '/');
    }

    /**
     * Get config based absolute path
     *
     * @param $path
     * @return string
     */
    public static function getConfigBasedAbsolutePath($path)
    {
        if (static::isAbsolutePath($path)) {
            return $path;
        }

        return static::$configDirectory . '/' . $path;
    }
}
