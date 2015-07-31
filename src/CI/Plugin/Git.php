<?php
namespace CI\Plugin;

use CI\Plugin;

class Git extends Plugin
{
    public function execute()
    {
        $this->build->log->info('plugin: git started');

        $repo = $this->settings['repo'];
        $branch = isset($this->settings['branch']) ? $this->settings['branch'] : 'master';
        $commands = [];

        if (file_exists($this->build_dir . '/' . $this->build->name . '/.git')) {
            $commands[] = 'git fetch';
            $commands[] = sprintf('git checkout --track -b %s %s', $branch, 'origin/' . $branch);
            $commands[] = 'git pull';
        } else {
            $commands[] = sprintf(
                'git clone %s %s',
                $repo,
                $this->build_dir . '/' . $this->build->name
            );

            if ($branch != 'master') {
                $commands[] = sprintf(
                    'cd %s && git checkout --track -b %s %s',
                    $this->build_dir . '/' . $this->build->name,
                    $branch,
                    'origin/' . $branch
                );
            }
        }

        $this->build->runCommands($commands);
        $this->build->log->info('plugin: git finished');
    }
}
