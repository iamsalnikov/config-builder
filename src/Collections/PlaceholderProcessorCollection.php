<?php

namespace iamsalnikov\ConfigBuilder\Collections;

use iamsalnikov\ConfigBuilder\Interfaces\PlaceholderProcessor;

/**
 * Class PlaceholderProcessorCollection
 * @package iamsalnikov\ConfigBuilder\Collections
 */
class PlaceholderProcessorCollection
{
    /**
     * @var PlaceholderProcessor[]
     */
    protected $collection = [];

    /**
     * Get all processors
     *
     * @return PlaceholderProcessor[]
     */
    public function getAll()
    {
        return $this->collection;
    }

    /**
     * Add processor
     *
     * @param PlaceholderProcessor $processor
     * @return string
     */
    public function add(PlaceholderProcessor $processor)
    {
        $key = uniqid();

        $this->collection[$key] = $processor;

        return $key;
    }

    /**
     * Remove processor
     *
     * @param $key
     * @return $this
     */
    public function remove($key)
    {
        unset($this->collection[$key]);

        return $this;
    }

    /**
     * Remove all processors
     *
     * @return $this
     */
    public function removeAll()
    {
        $this->collection = [];

        return $this;
    }
}