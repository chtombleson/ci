<?php
require_once(dirname(__DIR__) . '/vendor/autoload.php');

use Symfony\Component\Console\Application;
use CI\Command\Build;

$application = new Application();
$application->add(new Build());
$application->run();
