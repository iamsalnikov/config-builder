<?php

namespace iamsalnikov\ConfigBuilder\PlaceholderProcessors;

use iamsalnikov\ConfigBuilder\Interfaces\PlaceholderProcessor;

/**
 * Class BasicProcessor
 * @package iamsalnikov\ConfigBuilder\PlaceholderProcessors
 */
class BasicProcessor implements PlaceholderProcessor
{
    protected $leftBorder;
    protected $rightBorder;

    /**
     * BasicProcessor constructor.
     * @param $leftBorder
     * @param $rightBorder
     */
    public function __construct($leftBorder, $rightBorder)
    {
        $this->leftBorder = $leftBorder;
        $this->rightBorder = $rightBorder;
    }

    /**
     * @inheritDoc
     */
    public function getPlaceholders($string)
    {
        $pattern = '/'
            . preg_quote($this->leftBorder, '/')
            . '(.*?)'
            . preg_quote($this->rightBorder, '/')
            . '/';
        $parseResult = preg_match_all($pattern, $string, $matches);

        if ($parseResult === false) {
            throw new Exception('Can not parse string');
        }

        return !empty($matches) && isset($matches[1])
            ? array_values(array_filter(array_unique($matches[1]), 'trim'))
            : [];
    }

    /**
     * @inheritDoc
     */
    public function replacePlaceholders($string, $placeholders)
    {
        $patterns = [];

        foreach ($placeholders as $placeholder => $value) {
            $patterns[] = $this->leftBorder . $placeholder . $this->rightBorder;
        }

        return str_replace($patterns, array_values($placeholders), $string);
    }
}
