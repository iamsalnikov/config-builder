<?php

namespace iamsalnikov\ConfigBuilder\Tests\Unit\Factories;

use iamsalnikov\ConfigBuilder\Factories\FactoryException;
use iamsalnikov\ConfigBuilder\Factories\ValueProviderFactory;
use PHPUnit\Framework\TestCase;

class ValueProviderFactoryTest extends TestCase
{
    /**
     * @dataProvider getBadConfigs
     */
    public function testBadConfigException($config)
    {
        $this->expectException(FactoryException::class);

        ValueProviderFactory::newObject($config);
    }

    /**
     * Return bad configs
     *
     * @return array
     */
    public function getBadConfigs()
    {
        return [
            [null],
            ['hello'],
            [[]],
            [['arguments' => ['hello']]],
            [['class' => ValueProviderFactoryTest::class]],
        ];
    }
}