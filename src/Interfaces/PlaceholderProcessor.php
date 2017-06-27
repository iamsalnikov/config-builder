<?php

namespace iamsalnikov\ConfigBuilder\Interfaces;

/**
 * Interface PlaceholderProcessor
 *
 * @package iamsalnikov\ConfigBuilder\Interfaces
 */
interface PlaceholderProcessor
{
    /**
     * Extract placeholders
     *
     * @param string $string
     * @return string[]
     */
    public function getPlaceholders($string);

    /**
     * Replace placeholders
     *
     * @param string $string string in which all placeholder will be replaced
     * @param string[] $placeholders data for placeholders, where key - is placeholder name,
     * and value - is placeholder value
     * @return string
     */
    public function replacePlaceholders($string, $placeholders);
}
