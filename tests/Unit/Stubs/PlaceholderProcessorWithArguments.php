<?php

namespace iamsalnikov\ConfigBuilder\Tests\Unit\Stubs;

use iamsalnikov\ConfigBuilder\Interfaces\PlaceholderProcessor;

class PlaceholderProcessorWithArguments implements PlaceholderProcessor
{
    public $leftBorder;
    public $rightBorder;

    public function __construct($leftBorder, $rightBorder)
    {
        $this->leftBorder = $leftBorder;
        $this->rightBorder = $rightBorder;
    }

    public function getPlaceholders($string)
    {
        // ...
    }

    public function replacePlaceholders($string, $placeholders)
    {
        // ...
    }
}
