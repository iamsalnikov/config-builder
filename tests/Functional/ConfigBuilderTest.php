<?php

namespace iamsalnikov\ConfigBuilder\Tests\Functional;

use iamsalnikov\ConfigBuilder\ConfigBuilder;
use iamsalnikov\ConfigBuilder\PlaceholderProcessors\BasicProcessor;
use iamsalnikov\ConfigBuilder\ValueProviders\Json;
use iamsalnikov\ConfigBuilder\ValueProviders\Yaml;
use PHPUnit\Framework\TestCase;

class ConfigBuilderTest extends TestCase
{
    /**
     * @param $expected
     * @param $string
     * @param $processors
     * @param $providers
     *
     * @dataProvider getProcessStringTestTable
     */
    public function testProcessString($expected, $string, $processors, $providers)
    {
        $configBuilder = new ConfigBuilder();

        foreach ($processors as $processor) {
            $configBuilder->getPlaceholderProcessors()->add($processor);
        }

        foreach ($providers as $provider) {
            $configBuilder->getValueProviders()->add($provider);
        }

        $this->assertEquals($expected, $configBuilder->processString($string));
    }

    /**
     * @return array
     */
    public function getProcessStringTestTable()
    {
        return [
            [
                'expected' => 'hello world twitter facebook',
                'string' => '/greet.0/ {{greet.1}} {{socials.tw}} [socials.fb]',
                'placeholderProcessors' => [
                    new BasicProcessor('/', '/'),
                    new BasicProcessor('[', ']'),
                    new BasicProcessor('{{', '}}'),
                ],
                'valueProviders' => [
                    new Yaml(__DIR__ . '/data/config_builder_greet.yaml'),
                    new Json(__DIR__ . '/data/config_builder_socials.json'),
                ]
            ]
        ];
    }
}