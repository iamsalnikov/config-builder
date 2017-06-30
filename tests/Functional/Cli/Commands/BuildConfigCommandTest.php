<?php

namespace iamsalnikov\ConfigBuilder\Tests\Functional\Cli\Commands;

use iamsalnikov\ConfigBuilder\Cli\Commands\BuildConfigCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

class BuildConfigCommandTest extends TestCase
{

    /**
     * @param $file
     * @param $config
     *
     * @dataProvider getWrongArgumentsTestTable
     */
    public function testWrongRun($file, $config)
    {
        $this->expectException(RuntimeException::class);

        $command = new BuildConfigCommand();
        $tester = new CommandTester($command);
        $tester->execute([
            'file' => $file,
            '--config' => $config
        ]);
    }

    public function getWrongArgumentsTestTable()
    {
        return [
            ['file' => '', 'config' => ''],
            ['file' => __DIR__ . '/../../data/replace.php', 'config' => ''],
            ['file' => '', 'config' => __DIR__ . '/../../data/config_builder_config.yml'],
            ['file' => __DIR__, 'config' => ''],
            ['file' => '', 'config' => __DIR__],
            ['file' => __DIR__, 'config' => __DIR__],
        ];
    }

    /**
     * @param $file
     * @param $config
     * @param $expectedContent
     *
     * @dataProvider getGoodArgumentsTestTable
     */
    public function testReplace($file, $config, $expectedContent)
    {
        $command = new BuildConfigCommand();
        $tester = new CommandTester($command);
        $tester->execute([
            'file' => $file,
            '--config' => $config
        ]);

        $this->assertEquals(file_get_contents($expectedContent), $tester->getDisplay());
    }

    public function getGoodArgumentsTestTable()
    {
        return [
            [
                'file' => __DIR__ . '/../../data/replace.php',
                'config' => __DIR__ . '/../../data/config_builder_config.yml',
                'expectedContent' => __DIR__ . '/../../data/expected/replace_expect_for_config_builder_greet.php'
            ],
        ];
    }
}
