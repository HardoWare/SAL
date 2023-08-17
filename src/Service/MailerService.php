<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
    )
    {}
    public function sendMail($body): void
    {
        $from = "mailowacmuszebosieudusze@op.pl";
        $from_name = "Mail Bezdechu";
        $to = "mailowacmuszebosieudusze@op.pl";
        $subject = "System error";

        $email = (new Email())
            ->from(new Address("{$from}", "{$from_name}"))
            ->to("{$to}")
            ->subject("{$subject}")
            ->text("{$body}")
        ;
        $this->mailer->send($email);
    }
}