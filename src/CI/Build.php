<?php
namespace CI;

class Build
{
    public $log;
    public $name;
    public $log_path;
    protected $config;

    public function __construct($name, $config_path)
    {
        $this->log_path  = dirname(dirname(__DIR__)) . '/logs/' . $name;
        $this->log_path .= '-build-' . date('Ymd\THis') . '.log';

        $this->log = new Log($name, $this->log_path);
        $this->config = new Config($config_path);
        $this->name = $name;
    }

    public function run()
    {
        $this->log->info('build: started');

        $setup = $this->config->get('setup');
        $test = $this->config->get('test');
        $tear_down = $this->config->get('tear_down');
        $deploy = $this->config->get('deploy');
        $notifications = $this->config->get('notifications');

        if ($setup) {
            $this->runSetup($setup);
        }

        if ($test) {
            $this->runTest($test);
        }

        if ($tear_down) {
            $this->runTearDown($tear_down);
        }

        if ($deploy) {
            $this->runDeploy($deploy);
        }

        if ($notifications) {
            $this->runNotifications($notifications);
        }

        $this->log->info('build: finished');
    }

    public function runSetup($setup)
    {
        $this->log->info('build: setup started');

        $plugins = [];

        foreach ($setup as $plugin => $settings) {
            $plugins[] = [
                'name' => $plugin,
                'settings' => $settings,
            ];
        }

        $this->executePlugins($plugins);

        $this->log->info('build: setup finished');
    }

    public function runTest($test)
    {
        $this->log->info('build: test started');

        $plugins = [];

        foreach ($test as $plugin => $settings) {
            $plugins[] = [
                'name' => $plugin,
                'settings' => $settings,
            ];
        }

        $this->executePlugins($plugins);

        $this->log->info('build: test finished');
    }

    public function runTearDown($tear_down)
    {
        $this->log->info('build: tear down started');

        $plugins = [];

        foreach ($tear_down as $plugin => $settings) {
            $plugins[] = [
                'name' => $plugin,
                'settings' => $settings,
            ];
        }

        $this->executePlugins($plugins);

        $this->log->info('build: tear down finished');
    }

    public function runDeploy($deploy)
    {
        $this->log->info('build: deploy started');

        $plugins = [];

        foreach ($deploy as $plugin => $settings) {
            $plugins[] = [
                'name' => $plugin,
                'settings' => $settings,
            ];
        }

        $this->executePlugins($plugins);

        $this->log->info('build: deploy finished');
    }

    public function executePlugins($plugins)
    {
        foreach ($plugins as $plugin) {
            $class = '\CI\Plugin\\' . $plugin['name'];

            $plugin_obj = new $class($this, $plugin['settings']);
            $plugin_obj->execute();
        }
    }

    public function runNotifications($notifications)
    {
        $this->log->info('build: notifications started');

        $plugins = [];

        foreach ($notifications as $plugin => $settings) {
            $plugins[] = [
                'name' => $plugin,
                'settings' => $settings,
            ];
        }

        $this->executePlugins($plugins);

        $this->log->info('build: notifications finished');
    }

    public function runCommands($commands)
    {
        $current_dir = getcwd();

        $build_dir = dirname(dirname(__DIR__)) . '/builds';

        if (file_exists($build_dir . '/' . $this->name)) {
            $build_dir .= '/' . $this->name;
        }

        chdir($build_dir);

        foreach ($commands as $command) {
            $this->log->info('running command: ' . $command);
            exec($command, $output);
        }

        chdir($current_dir);
    }
}
