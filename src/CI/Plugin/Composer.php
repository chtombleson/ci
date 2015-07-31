<?php
namespace CI\Plugin;

use CI\Plugin;

class Composer extends Plugin
{
    public function execute()
    {
        $this->build->log->info('plugin: composer started');

        $action = isset($this->settings['action']) ? $this->settings['action'] : 'install';
        $directory = isset($this->settings['directory']) ? $this->settings['directory'] : null;
        $prefer_dist = isset($this->settings['prefer_dist']) ? $this->settings['prefer_dist'] : false;
        $commands = [];

        $cmd = 'composer';

        switch ($action) {
            case 'install':
                $cmd .= ' install';
                break;

            case 'update':
                $cmd .= ' update';
                break;
        }

        if ($prefer_dist) {
            $cmd .= ' --prefer-dist';
        }

        if ($directory) {
            $cmd = sprintf($cmd . ' --working-dir=%s', $directory);
        }

        $commands[] = $cmd;
        $this->build->runCommands($commands);
        $this->build->log->info('plugin: composer finished');
    }
}
