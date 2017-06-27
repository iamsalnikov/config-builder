<?php

namespace iamsalnikov\ConfigBuilder\Tests\Unit\Stubs;

use iamsalnikov\ConfigBuilder\Interfaces\ValueProvider;

class ValueProviderWithoutArguments implements ValueProvider
{
    public function getValue($param)
    {
        // ...
    }
}
