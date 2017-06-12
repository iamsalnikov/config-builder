<?php

namespace iamsalnikov\ConfigBuilder\ValueProviders;

use iamsalnikov\ConfigBuilder\Interfaces\ValueProvider;
use iamsalnikov\ConfigBuilder\Utils\Str;

/**
 * Class Environment
 * @package iamsalnikov\ConfigBuilder\ValueProviders
 */
class Environment implements ValueProvider
{
    /**
     * @var string prefix for environment variables
     */
    protected $envPrefix = '';

    /**
     * Environment constructor
     *
     * @param string $envPrefix
     */
    public function __construct($envPrefix = '')
    {
        $this->envPrefix = $envPrefix;
    }

    /**
     * @inheritdoc
     */
    public function getValue($param)
    {
        return getenv($this->getEnvParamName($param));
    }

    /**
     * Get param name for environment
     *
     * @param string $param
     * @return string
     */
    protected function getEnvParamName($param)
    {
        $param = Str::insertBeforeCapitalLetters('_', $param);
        $param = preg_replace('/([\.])([^_])/', '_$2', $param);

        return $this->envPrefix . strtoupper($param);
    }
}