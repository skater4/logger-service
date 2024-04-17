<?php

namespace App\Console\Commands;

use App\Services\Logger\Interfaces\LoggerInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class DeleteLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Completely removes log';

    /**
     * Execute the console command.
     *
     * @param LoggerInterface $logger
     * @return int
     */
    public function handle(LoggerInterface $logger): int
    {
        $logger->deleteLog();

        return CommandAlias::SUCCESS;
    }
}
