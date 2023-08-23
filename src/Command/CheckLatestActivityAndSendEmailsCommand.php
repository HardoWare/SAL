<?php

namespace App\Command;

use App\Service\DatabaseService;
use App\Service\MailerService;
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
        private readonly MailerService $mailerService,
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
            $timeDiff = $remoteHostLastLog["timeDiff"];

            if ($timeDiff->invert) {

                [$subject, $text] = $this->getSubjectAndText($remoteHostLastLog);
                //$this->mailerService->sendMail($subject, $text);
            }
        }

        //TODO: Sprawdzanie niewysłanych maili
        //shell_exec("php bin/console messenger:consume async");



        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
    private function getSubjectAndText($remoteHostLastLog): array
    {
        $rh = $remoteHostLastLog["remoteHostName"];
        $td = $remoteHostLastLog["timeDiff"];
        $pt = $td->format("%d dni %H:%I:%S");
        $subject = "Brak aktywności z hostem {$rh}";
        $text = "Wiadomość od {$rh} nie została dostarczona od {$pt}, zaleca się sprawdzenie połączenia z watchdogiem.";


        return [$subject, $text];
    }
}
