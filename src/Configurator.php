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
     * @return ValueProvider[]
     */
    public function getValueProviders()
    {
        $providers = [];

        foreach ($this->config['value_providers'] as $name => $providerConfig) {
            $providers[$name] = ValueProviderFactory::newObject($providerConfig);
        }

        return $providers;
    }

    /**
     * Create placeholder processors
     *
     * @return PlaceholderProcessor[]
     */
    public function getPlaceholderProcessors()
    {
        $processors = [];

        foreach ($this->config['placeholder_processors'] as $name => $processorConfig) {
            $processors[$name] = PlaceholderProcessorFactory::newObject($processorConfig);
        }

        return $processors;
    }
}