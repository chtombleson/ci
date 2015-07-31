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
   * Slack
   * HipChat
   * Grunt
   * Npm

## Current plugins

  * Composer
  * Email
  * Git
  * PHP Code Sniffer (PHPCS)
  * PHPUnit
  * Rsync
  * Shell

### Composer

Settings

  * action: install | update (Required)
  * directory: directory that contains composer.json | project root (Optional)
  * prefer_dist: true | false (Optional)

Example config

    setup:
      Composer:
        action: [install|update]
        [directory: working dir]
        [prefer_dist: [true | false]]

### Email

Settings

  * to: send email to (Required)
  * from: email from (Optional)
  * reply_to: email reply to (Optional)
  * subject: email subject (Optional)

Example config

    notifications:
      Email:
        to: email address
        [from: email address]
        [reply_to: email address]
        [subject: email subject]

### Git

Settings

  * repo: repo url (Required)
  * branch: git branch (Optional)

Example config

    setup:
      Git:
        repo: https://github.com/chtombleson/ci.git
        [branch: git branch | master]

### PHP Code Sniffer (PHPCS)

Settings

  * bin: path to phpcs binary (Optional)
  * standard: code sniffer standard (Required)
  * ignores: files/directories to ignore (Optional)

Example config

    test:
      PHPCS:
        standard: PSR2
        [bin: path to phpcs binary]
        [ignore: files/directories to ignore]

### PHPUnit

Settings

  * bin: path to phpunit binary (Optional)
  * config: path to phpunit.xml (Required)
  * bootstrap: path to bootstrap file (Optional)

Example config

    test:
      PHPUnit:
        config: path to phpunit.xml
        [bin: path to phpunit]
        [bootstrap: path to bootstrap file]

### Rsync

Settings

  * source: source directory/file to sync (Required)
  * destination: destination to sync to (Required)
  * options: string of options (Optional)
  * excludes: files/directories to exclude (Optional)

Example config

    deploy:
      Rsync:
        source: source directory/file
        destination: destination to sync to
        [options: string of command line args]
        [excludes: directories/files to exclude]

### Shell

Settings

  * command: command to run

Example config

    setup|test|tear_down|deploy:
      Shell:
        command: command to run

## Example Project Yaml File

    setup:
      Git:
        repo: https://github.com/chtombleson/ci.git
      Composer:
        action: install

    test:
      PHPUnit:
        config: phpunit.xml

    deploy:
      Rsync:
        source: build_dir/ci
        destination: user@server:/home/ci

    notifications:
      Email:
        to: myself@your.domain
