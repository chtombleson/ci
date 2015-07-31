<?php
namespace CI\Plugin;

use CI\Plugin;

class Shell extends Plugin
{
    public function execute()
    {
        $this->build->log->info('plugin: shell started');

        $command = $this->settings['command'];
        $commands = [$command];

        $this->build->runCommands($commands);
        $this->build->log->info('plugin: shell finished');
    }
}
