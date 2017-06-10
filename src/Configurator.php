<?php

namespace iamsalnikov\ConfigBuilder;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Configurator
 *
 * @package iamsalnikov\ConfigBuilder
 */
class Configurator
{
    /**
     * @var string path to config file
     */
    protected $configFilePath = '';

    protected $config = [];

    /**
     * Configurator constructor
     *
     * @param string $configFilePath
     */
    public function __construct($configFilePath)
    {
        $this->configFilePath = (string) $configFilePath;

        $this->readConfig();
    }

    /**
     * Read config
     *
     * @return $this
     */
    protected function readConfig()
    {
        $this->config = Yaml::parse(file_get_contents($this->configFilePath));

        return $this;
    }
}