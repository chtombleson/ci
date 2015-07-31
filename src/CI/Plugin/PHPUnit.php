<?php
namespace CI\Plugin;

use CI\Plugin;

class PHPUnit extends Plugin
{
    public function execute()
    {
        $this->build->log->info('plugin: phpunit started');

        $bin = isset($this->settings['bin']) ?
            $this->settings['bin'] : dirname(dirname(dirname(__DIR__))) . '/vendor/bin/phpunit';

        $config = isset($this->settings['config']) ? $this->settings['config'] ? 'phpunit.xml';
        $bootstrap = isset($this->settins['bootstrap']) ? $this->settings['bootstrap'] : null;

        $commands = [];

        if ($bootstrap) {
            $commands[] = sprintf('%s --bootstrap %s --configuration %s', $bin, $bootstrap, $config);
        } else {
            $commands[] = sprintf('%s --configuration %s', $bin, $config);
        }

        $this->build->runCommands($commands);
        $this->build->log->info('plugin: phpunit finished');
    }
}
