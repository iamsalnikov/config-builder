<?php

namespace iamsalnikov\ConfigBuilder\Tests\Unit\Factories;

use iamsalnikov\ConfigBuilder\Factories\FactoryException;
use iamsalnikov\ConfigBuilder\Factories\PlaceholderProcessorFactory;
use iamsalnikov\ConfigBuilder\Interfaces\PlaceholderProcessor;
use iamsalnikov\ConfigBuilder\Tests\Unit\Stubs\PlaceholderProcessorWithArguments;
use iamsalnikov\ConfigBuilder\Tests\Unit\Stubs\PlaceholderProcessorWithoutArguments;
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

    /**
     * @dataProvider getGoodConfigs
     * @param $config
     */
    public function testGoodConfig($config)
    {
        $processor = PlaceholderProcessorFactory::newObject($config);
        $this->assertTrue($processor instanceof PlaceholderProcessor);

        if (!isset($config['arguments'])) {
            return;
        }

        foreach ($config['arguments'] as $argument => $value) {
            $this->assertEquals($value, $processor->$argument);
        }
    }

    public function getGoodConfigs()
    {
        return [
            [
                'config' => [
                    'class' => PlaceholderProcessorWithoutArguments::class,
                ],
            ],

            [
                'config' => [
                    'class' => PlaceholderProcessorWithArguments::class,
                    'arguments' => [
                        'leftBorder' => 'left',
                        'rightBorder' => 'right',
                    ]
                ]
            ],
        ];
    }
}