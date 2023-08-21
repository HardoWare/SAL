<?php

namespace App\Command;

use App\Service\DatabaseService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:check-latest-activity-and-send-emails',
    description: 'Add a short description for your command',
)]
class CheckLatestActivityAndSendEmailsCommand extends Command
{
    public function __construct(
        private readonly DatabaseService $databaseService,
    )
    {
        parent::__construct();
    }
    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $remoteHostLastLogs = $this->databaseService->getOstatniePolaczeniaZApi();

        foreach ($remoteHostLastLogs as $remoteHostLastLog) {
            $rr = $remoteHostLastLog;
            $logTimeStamp = new \DateTime( "{$remoteHostLastLog["timeStamp"]}");
            list($H, $i, $s) = explode(":", $remoteHostLastLog["interval"]);
            $intStr = "PT{$H}H{$i}i{$s}s";
            $interval = new \DateInterval(sprintf('PT%dH%dM%dS', $H, $i, $s));


            $uooo = $remoteHostLastLog;
        }





        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
