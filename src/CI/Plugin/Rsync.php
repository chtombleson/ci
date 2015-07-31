<?php
namespace CI\Plugin;

use CI\Plugin;

class Rsync extends Plugin
{
    public function execute()
    {
        $this->build->log->info('plugin: rsync started');

        $source = $this->settings['source'];
        $destination = $this->settings['destination'];
        $options = isset($this->settings['options']) ? $this->settings['options'] : '-a';
        $excludes = isset($this->settings['exclude']) ? $this->settings['exclude'] : ['.git'];

        $commands = [];

        $cmd = 'rsync %s %s %s';

        if (!in_array($excludes)) {
            $excludes = [$excludes];
        }

        $exclude_opt = '';

        foreach ($excludes as $exclude) {
            $exclude_opt .= sprintf('--exclude="%s" ', $exclude);
        }

        trim($exclude_opt);

        $command = sprintf($cmd . ' %s', $options, $source, $destination, $exclude_opt);
        $commands[] = $command;

        $this->build->runCommands($commands);
        $this->build->log->info('plugin: rsync finished');
    }
}
