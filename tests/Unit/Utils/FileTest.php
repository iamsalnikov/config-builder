<?php

namespace iamsalnikov\ConfiBuilder\Tests\Unit\Utils;

use iamsalnikov\ConfigBuilder\Utils\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /**
     * @param $expected
     * @param $path
     * @dataProvider getIsAbsolutePathTestTable
     */
    public function testIsAbsolutePath($expected, $path)
    {
        $this->assertEquals($expected, File::isAbsolutePath($path));
    }

    /**
     * Test table for absolute path
     *
     * @return array
     */
    public function getIsAbsolutePathTestTable()
    {
        return [
            [
                'expected' => false,
                'path' => '',
            ],

            [
                'expected' => false,
                'path' => 'hello/world',
            ],

            [
                'expected' => true,
                'path' => '/',
            ],

            [
                'expected' => true,
                'path' => '/hello/world',
            ],
        ];
    }

    /**
     * @param $expected
     * @param $path
     * @dataProvider getUserAbsolutePathTestTable
     */
    public function testGetUserAbsolutePath($expected, $path)
    {
        $this->assertEquals($expected, File::getUserAbsolutePath($path));
    }

    public function getUserAbsolutePathTestTable()
    {
        return [
            [
                'expected' => '/hello/world',
                'path' => '/hello/world',
            ],

            [
                'expected' => getcwd() . '/hello/world',
                'path' => 'hello/world',
            ],
        ];
    }
}
