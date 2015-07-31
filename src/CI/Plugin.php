<?php
namespace CI;

use CI\Build;

abstract class Plugin
{
    protected $build;
    protected $settings;
    public $build_dir;

    public function __construct(Build $build, $settings)
    {
        $this->build = $build;
        $this->settings = $settings;

        $this->build_dir = dirname(dirname(__DIR__)) . '/builds';
    }

    abstract public function execute();
}
