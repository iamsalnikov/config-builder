<?php

namespace iamsalnikov\ConfigBuilder\Tests\Unit\Factories;

use iamsalnikov\ConfigBuilder\Factories\FactoryException;
use iamsalnikov\ConfigBuilder\Factories\PlaceholderProcessorFactory;
use PHPUnit\Framework\TestCase;

class PlaceholderProcessorFactoryTest extends TestCase
{
    /**
     * @dataProvider getBadConfigs
     */
    public function testBadConfigException($config)
    {
        $this->expectException(FactoryException::class);

        PlaceholderProcessorFactory::newObject($config);
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
            [['class' => PlaceholderProcessorFactoryTest::class]],
        ];
    }
}