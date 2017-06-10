<?php

namespace iamsalnikov\ConfigBuilder\Interfaces;

/**
 * Interface ValueProvider
 *
 * @package iamsalnikov\ConfigBuilder\Interfaces
 */
interface ValueProvider
{
    /**
     * Get value
     *
     * @param string $param string. For deep you can use dots.
     *
     * For example: "user.name"
     *
     * @return mixed
     */
    public function getValue($param);
}