<?php

namespace iamsalnikov\ConfiBuilder\Tests\Unit\Utils;

use iamsalnikov\ConfigBuilder\Utils\Exception;
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

    /**
     * @param $path
     * @param $expectedException
     *
     * @dataProvider getSetConfigDirectoryTestTable
     */
    public function testSetConfigDirectory($path, $expectedException)
    {
        if ($expectedException) {
            $this->expectException($expectedException);
        }

        File::setConfigDirectory($path);
    }

    public function getSetConfigDirectoryTestTable()
    {
        return [
            ['path' => 'undefined_path', 'expectedException' => Exception::class],
            ['path' => __DIR__, 'expectedException' => null],
        ];
    }

    /**
     * @param $expected
     * @param $path
     * @param $configDirectory
     * @dataProvider getConfigBasedAbsolutePathTestTable
     */
    public function testGetConfigBasedAbsolutePath($expected, $path, $configDirectory)
    {
        File::setConfigDirectory($configDirectory);
        $this->assertEquals($expected, File::getConfigBasedAbsolutePath($path));
    }

    public function getConfigBasedAbsolutePathTestTable()
    {
        return [
            [
                'expected' => '/hello/world',
                'path' => '/hello/world',
                'configDirectory' => __DIR__,
            ],

            [
                'expected' => __DIR__ . '/hello/world',
                'path' => 'hello/world',
                'configDirectory' => __DIR__,
            ],
        ];
    }
}
