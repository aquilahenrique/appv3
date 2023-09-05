<?php

declare(strict_types=1);

namespace App\Command;

use App\Services\StoreHashService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'avato:test',
)]
class AvatoTestCommand extends Command
{

    public function __construct(private readonly StoreHashService $storeHashService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('word', InputArgument::REQUIRED)
            ->addOption('requests', mode: InputOption::VALUE_REQUIRED, default: 5)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $word = $input->getArgument('word');
        $requests = (int) $input->getOption('requests');

        try {
            $this->storeHashService->store($word, $requests);
        }catch (\Throwable $throwable) {
            $output->writeln($throwable->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
