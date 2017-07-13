<?php

namespace iamsalnikov\ConfigBuilder\Cli\Commands;

use iamsalnikov\ConfigBuilder\ConfigBuilder;
use iamsalnikov\ConfigBuilder\Configurator;
use iamsalnikov\ConfigBuilder\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
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
            ->addOption('config', 'c', InputOption::VALUE_OPTIONAL, 'Builder\'s config file', 'config_builder.yaml');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFilePath = File::getUserAbsolutePath($input->getOption('config'));
        if (!file_exists($configFilePath) || !is_file($configFilePath) || !is_readable($configFilePath)) {
            throw new RuntimeException('Config builder configuration file was not found (' . $configFilePath . ')');
        }

        $targetFilePath = File::getUserAbsolutePath($input->getArgument('file'));
        if (!file_exists($targetFilePath) || !is_file($targetFilePath) || !is_readable($targetFilePath)) {
            throw new RuntimeException('Config builder target file was not found (' . $targetFilePath . ')');
        }

        File::setConfigDirectory(dirname($configFilePath));
        $builder = $this->getConfigBuilder($configFilePath);

        $output->write($builder->processString(file_get_contents($targetFilePath)));
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
