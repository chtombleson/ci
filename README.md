# CI (Continuous Integration)

A simple PHP continuous integration program.

## How to

All projects are configured with a yaml file in the config/projects directory.

Example yaml:

    setup:
      Git:
        repo: https://github.com/chtombleson/ci.git
      Composer:
        action: install
    test:
    tear_down:
    deploy:
    notifications:
      Email:
        to: yourself@example.com

To run a build `php bin/console.php ci:build-project [name]`

The build logs are in the log directory.

## TODO

  * Add polling
  * Web interface (Maybe)
  * Add more plugins
   * PHPUnit
   * PHP Code Sniffer
   * PHP Mess Detector
   * Slack
   * HipChat
   * Rsync
   * Grunt
   * Npm
