<?php

namespace Controllers\Cli;

use Controllers\Cli\OutputAdapters\SymfonyOutput;
use Controllers\Database\Adapters\MysqlAdapter;
use Controllers\Logger\Log;
use Controllers\Migrations\Schematic;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SchematicConsoleApp extends Command
{

    protected function configure()
    {
        $this
            ->setName('migrations:execute')
            ->setDescription('Executes the database migration based on the JSON schema files')
            ->addArgument(
                'dir',
                InputArgument::REQUIRED,
                'What is the folder the schema files live in?'
            )
            ->addArgument(
                'env',
                InputArgument::REQUIRED,
                'What is the environment?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $directory = $input->getArgument('dir');
        $environment = $input->getArgument('env');

        $database = 'mysql';

        switch($database)
        {

            case 'mysql':
                $db = new MysqlAdapter();
                break;

            default:
                throw new \Exception('Must be valid adapter.. e.g. mysql');

        }

        $output->writeln('<info>Beginning migrations</info>');

        $log = new Log();
        $schematicOutput = new SymfonyOutput($output);

        $schematic = new Schematic($log, $db, $schematicOutput);
        $schematic
            ->setDir($directory)
            ->setEnvironmentConfigs($environment)
            ->run()
        ;

        $output->writeln('<info>Migrations completed successfully!</info>');

    }

}