<?php

namespace iamsalnikov\ConfigBuilder;

use iamsalnikov\ConfigBuilder\Collections\PlaceholderProcessorCollection;
use iamsalnikov\ConfigBuilder\Collections\ValueProviderCollection;
use iamsalnikov\ConfigBuilder\Values\Nil;

/**
 * Class ConfigBuilder
 * @package iamsalnikov\ConfigBuilder
 */
class ConfigBuilder
{
    /**
     * @var PlaceholderProcessorCollection
     */
    protected $placeholderProcessors;

    /**
     * @var ValueProviderCollection
     */
    protected $valueProviders;

    /**
     * ConfigBuilder constructor
     */
    public function __construct()
    {
        $this->placeholderProcessors = new PlaceholderProcessorCollection();
        $this->valueProviders = new ValueProviderCollection();
    }

    /**
     * Get placeholder processors
     *
     * @return PlaceholderProcessorCollection
     */
    public function getPlaceholderProcessors()
    {
        return $this->placeholderProcessors;
    }

    /**
     * Get value providers
     *
     * @return ValueProviderCollection
     */
    public function getValueProviders()
    {
        return $this->valueProviders;
    }

    /**
     * Process string
     *
     * @param $string
     * @return string
     */
    public function processString($string)
    {
        foreach ($this->placeholderProcessors->getAll() as $pp) {
            $placeholders = array_flip($pp->getPlaceholders($string));
            $placeholders = $this->processPlaceholders($placeholders);
            $string = $pp->replacePlaceholders($string, $placeholders);
        }

        return $string;
    }

    /**
     * Process placeholder
     *
     * @param $placeholders
     * @return mixed
     */
    protected function processPlaceholders($placeholders)
    {
        foreach ($placeholders as $placeholder => $v) {
            $placeholders[$placeholder] = $this->processPlaceholder($placeholder);
        }

        return $placeholders;
    }

    /**
     * Process placeholder
     *
     * @param $placeholder
     * @return mixed|null
     */
    protected function processPlaceholder($placeholder)
    {
        foreach ($this->valueProviders->getAll() as $vp) {
            $value = $vp->getValue($placeholder);
            if (!($value instanceof Nil)) {
                return $value;
            }
        }

        return null;
    }
}
