<?php

namespace iamsalnikov\ConfigBuilder\Cli\Commands;

use iamsalnikov\ConfigBuilder\ConfigBuilder;
use iamsalnikov\ConfigBuilder\Configurator;
use iamsalnikov\ConfigBuilder\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BuildConfigCommand
 * @package iamsalnikov\ConfigBuilder\Cli\Commands
 */
class BuildConfigCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('build')
            ->setDescription('Build config');

        $this->ignoreValidationErrors();

        $this->addArgument('file', InputArgument::REQUIRED, 'File with for replacing')
            ->addOption('config', 'c', InputOption::VALUE_OPTIONAL, 'Builder\'s config file', getcwd() . '/config_builder.yaml');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFilePath = File::getUserAbsolutePath($input->getOption('config'));
        $builder = $this->getConfigBuilder($configFilePath);

        $filePath = File::getUserAbsolutePath($input->getArgument('file'));
        echo $builder->processString(file_get_contents($filePath));
    }

    /**
     * Get config builder
     *
     * @param $configFilePath
     * @return ConfigBuilder
     */
    protected function getConfigBuilder($configFilePath)
    {
        $configurator = new Configurator($configFilePath);
        $builder = new ConfigBuilder();

        foreach ($configurator->getPlaceholderProcessors() as $pp) {
            $builder->getPlaceholderProcessors()->add($pp);
        }

        foreach ($configurator->getValueProviders() as $vp) {
            $builder->getValueProviders()->add($vp);
        }

        return $builder;
    }
}