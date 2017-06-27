<?php

namespace iamsalnikov\ConfigBuilder\Cli;

use iamsalnikov\ConfigBuilder\Cli\Commands\BuildConfigCommand;

/**
 * Class Application
 * @package iamsalnikov\ConfigBuilder\Cli
 */
class Application
{
    public static function run()
    {
        $app = new \Symfony\Component\Console\Application();
        $app->addCommands([new BuildConfigCommand()]);
        $app->setDefaultCommand('build', true);

        $app->run();
    }
}
