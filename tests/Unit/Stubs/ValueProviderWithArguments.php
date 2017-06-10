<?php

namespace iamsalnikov\ConfigBuilder\Tests\Unit\Stubs;

use iamsalnikov\ConfigBuilder\Interfaces\ValueProvider;

class ValueProviderWithArguments implements ValueProvider
{
    public $property1;
    public $property2;

    public function __construct($property1, $property2)
    {
        $this->property1 = $property1;
        $this->property2 = $property2;
    }

    public function getValue($param)
    {

    }
}