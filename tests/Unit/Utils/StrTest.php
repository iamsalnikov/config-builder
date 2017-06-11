<?php

namespace iamsalnikov\ConfiBuilder\Tests\Unit\Utils;

use iamsalnikov\ConfigBuilder\Utils\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    /**
     * @dataProvider getStringsForCapitalLetters
     * @param $expect
     * @param $string
     * @param $delimiter
     */
    public function testInsertBeforeCapitalLetters($expect, $string, $delimiter)
    {
        $this->assertEquals($expect, Str::insertBeforeCapitalLetters($delimiter, $string));
    }

    public function getStringsForCapitalLetters()
    {
        return [
            [
                'expect' => '',
                'string' => '',
                'delimiter' => '_',
            ],

            [
                'expect' => 'hello',
                'string' => 'hello',
                'delimiter' => '_',
            ],

            [
                'expect' => 'Hello',
                'string' => 'Hello',
                'delimiter' => '_',
            ],

            [
                'expect' => 'HELLO',
                'string' => 'HELLO',
                'delimiter' => '_',
            ],

            [
                'expect' => 'hello_World',
                'string' => 'helloWorld',
                'delimiter' => '_',
            ],

            [
                'expect' => 'Hello_World',
                'string' => 'HelloWorld',
                'delimiter' => '_',
            ],

            [
                'expect' => 'Hello_WOrld',
                'string' => 'HelloWOrld',
                'delimiter' => '_',
            ],

            [
                'expect' => 'Hello_f_World',
                'string' => 'Hello_fWorld',
                'delimiter' => '_',
            ],

            [
                'expect' => 'Hello_f_World',
                'string' => 'Hello_f_World',
                'delimiter' => '_',
            ]
        ];
    }
}