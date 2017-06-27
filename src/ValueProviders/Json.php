<?php

namespace iamsalnikov\ConfigBuilder\ValueProviders;

use iamsalnikov\ConfigBuilder\Utils\Map;
use iamsalnikov\ConfigBuilder\Interfaces\ValueProvider;

/**
 * Class Json
 * @package iamsalnikov\ConfigBuilder\ValueProviders
 */
class Json implements ValueProvider
{
    /**
     * @var string path to config file
     */
    protected $filePath = '';

    /**
     * @var array config
     */
    protected $config = [];

    /**
     * Json constructor
     *
     * @param $filePath
     * @throws Exception
     */
    public function __construct($filePath)
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new Exception('Config file does not exists or does not readable');
        }

        $this->filePath = $filePath;
        $this->loadConfig();
    }

    /**
     * @inheritDoc
     */
    public function getValue($param)
    {
        return Map::getValue($param, $this->config);
    }

    /**
     * Load config
     *
     * @return $this
     */
    protected function loadConfig()
    {
        $this->config = json_decode(file_get_contents($this->filePath), true);

        return $this;
    }
}
