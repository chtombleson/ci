<?php
namespace CI\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Build extends Command
{
    protected function configure()
    {
        $this->setName('ci:build-project')
        ->setDescription('Build project')
        ->addArgument(
            'name',
            InputArgument::REQUIRED,
            'Project to build'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $config_path = dirname(dirname(dirname(__DIR__))) . '/config/projects/' . $name . '.yml';

        if (!file_exists($config_path)) {
            $output->writeln('<error>Error: Couldn\'t find project conf</error>');
            return;
        }

        $build = new \CI\Build($name, $config_path);
        $build->run();
    }
}
