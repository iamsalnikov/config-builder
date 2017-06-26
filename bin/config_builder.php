<?php

foreach ([__DIR__ . '/../../autoload.php', __DIR__ . '/../autoload.php', __DIR__ . '/../vendor/autoload.php', __DIR__ . '/vendor/autoload.php'] as $file) {
    if (file_exists($file)) {
        define('CONFIG_BUILDER_COMPOSER_INSTALL', $file);

        break;
    }
}

unset($file);

if (!defined('CONFIG_BUILDER_COMPOSER_INSTALL')) {
    fwrite(STDERR,
        'You need to set up the project dependencies using Composer:' . PHP_EOL . PHP_EOL .
        '    composer install' . PHP_EOL . PHP_EOL .
        'You can learn all about Composer on https://getcomposer.org/.' . PHP_EOL
    );

    die(1);
}

require CONFIG_BUILDER_COMPOSER_INSTALL;

\iamsalnikov\ConfigBuilder\Cli\Application::run();