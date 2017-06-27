<?php

namespace iamsalnikov\ConfigBuilder\Tests\Unit\PlaceholderProcessors;

use iamsalnikov\ConfigBuilder\PlaceholderProcessors\BasicProcessor;
use PHPUnit\Framework\TestCase;

class BasicProcessorTest extends TestCase
{
    /**
     * @param $expected
     * @param $leftBorder
     * @param $rightBorder
     * @param $text
     *
     * @dataProvider getPlaceholdersTestTable
     */
    public function testGetPlaceholders($expected, $leftBorder, $rightBorder, $text)
    {
        $processor = new BasicProcessor($leftBorder, $rightBorder);

        $this->assertEquals($expected, $processor->getPlaceholders($text));
    }

    /**
     * @return array
     */
    public function getPlaceholdersTestTable()
    {
        return [
            [
                'expected' => [],
                'leftBorder' => '/',
                'rightBorder' => '/',
                'text' => ""
            ],

            [
                'expected' => [],
                'leftBorder' => '/',
                'rightBorder' => '/',
                'text' => "Hello world"
            ],

            [
                'expected' => ['start'],
                'leftBorder' => '/',
                'rightBorder' => '/',
                'text' => "/start/ world"
            ],

            [
                'expected' => ['end'],
                'leftBorder' => '/',
                'rightBorder' => '/',
                'text' => "Hello /end/"
            ],

            [
                'expected' => ['start', 'middle', 'end', 'line'],
                'leftBorder' => '/',
                'rightBorder' => '/',
                'text' => "/start/ Hello /middle/ /end/\nNew /line/"
            ],

            [
                'expected' => ['unique'],
                'leftBorder' => '/',
                'rightBorder' => '/',
                'text' => "This is /unique/ param for checking /unique/ filter"
            ],

            [
                'expected' => ['params'],
                'leftBorder' => '/',
                'rightBorder' => '/',
                'text' => "We // ignore empty /params/"
            ],
        ];
    }

    /**
     * @param $expected
     * @param $leftBorder
     * @param $rightBorder
     * @param $text
     * @param $placeholders
     *
     * @dataProvider getReplacePlaceholdersTestTable
     */
    public function testReplacePlaceholders($expected, $leftBorder, $rightBorder, $text, $placeholders)
    {
        $processor = new BasicProcessor($leftBorder, $rightBorder);

        $this->assertEquals($expected, $processor->replacePlaceholders($text, $placeholders));
    }

    /**
     * @return array
     */
    public function getReplacePlaceholdersTestTable()
    {
        return [
            [
                'expected' => '',
                'leftBorder' => '/',
                'rightBorder' => '/',
                'text' => '',
                'placeholders' => [
                    'param' => 'world',
                ],
            ],

            [
                'expected' => 'Hello world email twitter',
                'leftBorder' => '/',
                'rightBorder' => '/',
                'text' => 'Hello /param/ email /param2/',
                'placeholders' => [
                    'param' => 'world',
                    'param2' => 'twitter'
                ],
            ],

            [
                'expected' => 'Hello world email world',
                'leftBorder' => '/',
                'rightBorder' => '/',
                'text' => 'Hello /param/ email /param/',
                'placeholders' => [
                    'param' => 'world',
                ],
            ],
        ];
    }
}
