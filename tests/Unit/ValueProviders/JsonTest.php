<?php

namespace iamsalnikov\ConfigBuilder\Tests\Unit\ValueProviders;

use iamsalnikov\ConfigBuilder\ValueProviders\Exception;
use iamsalnikov\ConfigBuilder\ValueProviders\Json;
use iamsalnikov\ConfigBuilder\Values\Nil;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    /**
     * @param $expected
     * @param $expectException
     * @param $param
     * @param $filePath
     *
     * @dataProvider getTestTableForGetValue
     */
    public function testGetValue($expected, $expectException, $param, $filePath)
    {
        if ($expectException) {
            $this->expectException(Exception::class);
        }

        $provider = new Json($filePath);
        $this->assertEquals($expected, $provider->getValue($param));
    }

    public function getTestTableForGetValue()
    {
        return [
            [
                'expected' => new Nil(),
                'expectException' => true,
                'param' => 'hello',
                'filePath' => 'undefined.file'
            ],
            [
                'expected' => 'test',
                'expectException' => false,
                'param' => 'hello.world',
                'filePath' => realpath(__DIR__ . '/../data/json_test_get_value.json'),
            ],
        ];
    }
}
