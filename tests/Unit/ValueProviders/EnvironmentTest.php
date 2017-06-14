<?php

namespace iamsalnikov\ConfigBuilder\Tests\Unit\ValueProviders;

use iamsalnikov\ConfigBuilder\ValueProviders\Environment;
use iamsalnikov\ConfigBuilder\Values\Nil;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * @param $prefix
     * @param $param
     * @param $envParam
     * @param $inEnv
     * @param $value
     *
     * @dataProvider getTestEnvTable
     */
    public function testGetValue($prefix, $param, $envParam, $inEnv, $value)
    {
        $provider = new Environment($prefix);
        if ($inEnv && $envParam) {
            putenv("$envParam=$value");
        }

        $this->assertEquals($value, $provider->getValue($param));
    }

    public function getTestEnvTable()
    {
        return [
            ['pr' => '',   'param' => 'test.param1', 'envParam' => 'TEST_PARAM1',    'inEnv' => false, 'value' => new Nil()],
            ['pr' => '',   'param' => 'test.param2', 'envParam' => 'TEST_PARAM2',    'inEnv' => true,  'value' => 'good1'],
            ['pr' => '',   'param' => 'testParam3',  'envParam' => 'TEST_PARAM3',    'inEnv' => false, 'value' => new Nil()],
            ['pr' => '',   'param' => 'testParam4',  'envParam' => 'TEST_PARAM4',    'inEnv' => true,  'value' => 'good2'],
            ['pr' => '',   'param' => '',           'envParam' => '',              'inEnv' => false, 'value' => new Nil()],
            ['pr' => '',   'param' => '',           'envParam' => '',              'inEnv' => true,  'value' => new Nil()],
            ['pr' => 'TT_', 'param' => 'test.param5', 'envParam' => 'TT_TEST_PARAM5', 'inEnv' => false, 'value' => new Nil()],
            ['pr' => 'TT_', 'param' => 'test.param6', 'envParam' => 'TT_TEST_PARAM6', 'inEnv' => true,  'value' => 'good3'],
            ['pr' => 'TT_', 'param' => 'testParam7',  'envParam' => 'TT_TEST_PARAM7', 'inEnv' => false, 'value' => new Nil()],
            ['pr' => 'TT_', 'param' => 'testParam8',  'envParam' => 'TT_TEST_PARAM8', 'inEnv' => true,  'value' => 'good4'],
            ['pr' => 'TT_', 'param' => '',           'envParam' => '',              'inEnv' => false, 'value' => new Nil()],
            ['pr' => 'TT_', 'param' => '',           'envParam' => '',              'inEnv' => true,  'value' => new Nil()],
        ];
    }
}