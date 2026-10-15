<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-demo',
    description: 'Import fictional demonstration data into a local database.'
)]
class ImportDemoCommand extends Command
{
    public function __construct(
        private readonly Connection $connection
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            'force',
            null,
            InputOption::VALUE_NONE,
            'Confirm that the target database is disposable.'
        );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);

        if (($_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'prod') !== 'dev') { {
            $io->error('Demo import is only available in dev.');
            return Command::FAILURE;
        }

        if (!$input->getOption('force')) {
            $io->warning(
                'This command is intended for a fresh, disposable database.'
            );
            $io->note('Run again with --force to confirm.');
            return Command::FAILURE;
        }

        $path = dirname(__DIR__, 2) . '/heating_demo_seed.sql';

        if (!is_file($path)) {
            $io->error('Demo SQL file not found.');
            return Command::FAILURE;
        }

        $sql = file_get_contents($path);

        if ($sql === false) {
            $io->error('Unable to read the demo SQL file.');
            return Command::FAILURE;
        }

        try {
            $this->connection->getNativeConnection()->exec($sql);
        } catch (\Throwable $exception) {
            $io->error($exception->getMessage());
            return Command::FAILURE;
        }

        $io->success('Demo data imported successfully.');

        return Command::SUCCESS;
    }
}
}
