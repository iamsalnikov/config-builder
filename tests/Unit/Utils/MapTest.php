<?php

namespace iamsalnikov\ConfiBuilder\Tests\Unit\Utils;

use iamsalnikov\ConfigBuilder\Utils\Map;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
    /**
     * @param $expected
     * @param $param
     * @param $map
     *
     * @dataProvider getTestTableForGetValue
     */
    public function testGetValue($expected, $param, $map)
    {
        $this->assertEquals($expected, Map::getValue($param, $map));
    }

    public function getTestTableForGetValue()
    {
        return [
            [
                'expected' => null,
                'param' => 'hello',
                'map' => [],
            ],
            [
                'expected' => null,
                'param' => 'hello',
                'map' => ['world' => 'test'],
            ],
            [
                'expected' => 'world',
                'param' => 'hello',
                'map' => ['hello' => 'world'],
            ],

            [
                'expected' => null,
                'param' => 'hello.world',
                'map' => [],
            ],
            [
                'expected' => null,
                'param' => 'hello.world',
                'map' => ['hello' => 'world'],
            ],
            [
                'expected' => null,
                'param' => 'hello.world',
                'map' => ['hello' => ['world']],
            ],
            [
                'expected' => 'email',
                'param' => 'hello.world',
                'map' => ['hello' => ['world' => 'email']],
            ],
            [
                'expected' => null,
                'param' => 'hello.1',
                'map' => ['hello' => ['world']],
            ],
            [
                'expected' => 'test',
                'param' => 'hello.1',
                'map' => ['hello' => ['world', 'test']],
            ],
            [
                'expected' => 'yo',
                'param' => 'hello.1.gmail',
                'map' => ['hello' => ['world', ['gmail' => 'yo']]],
            ],
        ];
    }
}