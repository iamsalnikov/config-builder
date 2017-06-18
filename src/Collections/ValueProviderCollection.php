<?php

namespace iamsalnikov\ConfigBuilder\Collections;

use iamsalnikov\ConfigBuilder\Interfaces\ValueProvider;

/**
 * Class ValueProviderCollection
 * @package iamsalnikov\ConfigBuilder\Collections
 */
class ValueProviderCollection
{
    /**
     * @var ValueProvider[]
     */
    protected $collection = [];

    /**
     * Get all providers
     *
     * @return ValueProvider[]
     */
    public function getAll()
    {
        return $this->collection;
    }

    /**
     * Add provider
     *
     * @param ValueProvider $provider
     * @return string
     */
    public function add(ValueProvider $provider)
    {
        $key = uniqid();

        $this->collection[$key] = $provider;

        return $key;
    }

    /**
     * Remove provider
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
     * Remove all providers
     *
     * @return $this
     */
    public function removeAll()
    {
        $this->collection = [];

        return $this;
    }
}