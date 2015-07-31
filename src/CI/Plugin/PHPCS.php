<?php
namespace CI\Plugin;

use CI\Plugin;

class PHPCS extends Plugin
{
    public function execute()
    {
        $this->build->log->info('plugin: php code sniffer started');

        $bin = isset($this->settings['bin']) ?
            $this->settings['bin'] : dirname(dirname(dirname(__DIR__))) . '/vendor/bin/phpcs';

        $standard = isset($this->settings['standard']) ? $this->settings['standard'] : 'PSR2';
        $ignores = isset($this->settings['ignore']) ? $this->settings['ignore'] : ['vendor'];

        $commands = [];

        if (!is_array($ignores)) {
            $ignores = [$ignores];
        }

        $ignore_opts = [];

        foreach ($ignores as $ignore) {
            $ignore_opts[] = sprintf('%s', $ignore);
        }

        $commands[] = sprintf('%s --ingore=%s --standard=%s', $bin, implode(',', $ignore_opts), $standard);

        $this->build->runCommands($commands);
        $this->build->log->info('plugin: php code sniffer finished');
    }
}
