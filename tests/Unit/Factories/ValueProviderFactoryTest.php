<?php

namespace iamsalnikov\ConfigBuilder\Tests\Unit\Factories;

use iamsalnikov\ConfigBuilder\Factories\FactoryException;
use iamsalnikov\ConfigBuilder\Factories\ValueProviderFactory;
use iamsalnikov\ConfigBuilder\Interfaces\ValueProvider;
use iamsalnikov\ConfigBuilder\Tests\Unit\Stubs\ValueProviderWithArguments;
use iamsalnikov\ConfigBuilder\Tests\Unit\Stubs\ValueProviderWithoutArguments;
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

    /**
     * @dataProvider getGoodConfigs
     * @param $config
     */
    public function testGoodConfig($config)
    {
        $processor = ValueProviderFactory::newObject($config);
        $this->assertTrue($processor instanceof ValueProvider);

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
                    'class' => ValueProviderWithoutArguments::class,
                ],
            ],

            [
                'config' => [
                    'class' => ValueProviderWithArguments::class,
                    'arguments' => [
                        'property1' => 'left',
                        'property2' => 'right',
                    ]
                ]
            ],
        ];
    }
}
