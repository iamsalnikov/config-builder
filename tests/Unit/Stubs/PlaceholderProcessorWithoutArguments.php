<?php

namespace iamsalnikov\ConfigBuilder\Tests\Unit\Stubs;

use iamsalnikov\ConfigBuilder\Interfaces\PlaceholderProcessor;

class PlaceholderProcessorWithoutArguments implements PlaceholderProcessor
{
    public function getPlaceholders($string)
    {

    }

    public function replacePlaceholders($string, $placeholders)
    {

    }
}