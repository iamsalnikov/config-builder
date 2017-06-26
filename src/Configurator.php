<?php

namespace iamsalnikov\ConfigBuilder;

use iamsalnikov\ConfigBuilder\Factories\PlaceholderProcessorFactory;
use iamsalnikov\ConfigBuilder\Factories\ValueProviderFactory;
use iamsalnikov\ConfigBuilder\Interfaces\PlaceholderProcessor;
use iamsalnikov\ConfigBuilder\Interfaces\ValueProvider;
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

        if (!array_key_exists('value_providers', $this->config)) {
            $this->config['value_providers'] = [];
        }

        if (!array_key_exists('placeholder_processors', $this->config)) {
            $this->config['placeholder_processors'] = [];
        }

        return $this;
    }

    /**
     * Create value providers
     *
     * @return \Generator|ValueProvider[]
     */
    public function getValueProviders()
    {
        foreach ($this->config['value_providers'] as $name => $providerConfig) {
            yield ValueProviderFactory::newObject($providerConfig);
        }
    }

    /**
     * Create placeholder processors
     *
     * @return \Generator|PlaceholderProcessor[]
     */
    public function getPlaceholderProcessors()
    {
        foreach ($this->config['placeholder_processors'] as $name => $processorConfig) {
            yield PlaceholderProcessorFactory::newObject($processorConfig);
        }
    }
}