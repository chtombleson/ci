<?php
require_once(dirname(__DIR__) . '/vendor/autoload.php');

use CI\Config;

$config = new Config(__DIR__ . '/ci.yml');

$phinx_conf = [
    "paths" => [
        "migrations" => dirname(__DIR__) . '/migrations',
    ],
    "environments" => [
        "default_migration_table" => "phinxlog",
        "default_database" => "ci",
        "ci" => [],
    ],
];

switch ($config->get('database.type')) {
    case 'mysql':
        $phinx_conf['environments']['ci']['adapter'] = 'mysql';
        $phinx_conf['environments']['ci']['host'] = $config->get('database.host');
        $phinx_conf['environments']['ci']['port'] = $config->get('database.port') ?: 3306;
        $phinx_conf['environments']['ci']['name'] = $config->get('database.dbname');
        $phinx_conf['environments']['ci']['user'] = $config->get('database.username');
        $phinx_conf['environments']['ci']['pass'] = $config->get('database.password');
        $phinx_conf['environments']['ci']['charset'] = 'utf8';
        break;

    case 'pgsql':
        $phinx_conf['environments']['ci']['adapter'] = 'pgsql';
        $phinx_conf['environments']['ci']['host'] = $config->get('database.host');
        $phinx_conf['environments']['ci']['port'] = $config->get('database.port') ?: 5432;
        $phinx_conf['environments']['ci']['name'] = $config->get('database.dbname');
        $phinx_conf['environments']['ci']['user'] = $config->get('database.username');
        $phinx_conf['environments']['ci']['pass'] = $config->get('database.password');
        break;

    case 'sqlite':
        $phinx_conf['environments']['ci']['adapter'] = 'sqlite';
        $phinx_conf['environments']['ci']['name'] = $config->get('database.path');
        break;
}

return $phinx_conf;
