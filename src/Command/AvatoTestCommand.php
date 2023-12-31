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
use Symfony\Component\Console\Style\SymfonyStyle;

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
        $io = new SymfonyStyle($input, $output);
        $word = $input->getArgument('word');
        $requests = (int) $input->getOption('requests');

        try {
            $this->storeHashService->store($word, $requests);
            $io->success('Hashes gerados com sucesso.');
        }catch (\Throwable $throwable) {
            $io->error($throwable->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
