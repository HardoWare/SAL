<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private readonly MailerInterface $mailer,
    )
    {}

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMail($body): void
    {
        $from = "mailowacmuszebosieudusze@op.pl";
        $from_name = "Mail Bezdechu";
        $to = "mailowacmuszebosieudusze@op.pl";
        $subject = "System error";
        $message = var_export($body, true);

        $email = (new Email())
            ->from(new Address($from, $from_name))
            ->to($to)
            ->subject($subject)
            ->text($message)
        ;
        $this->mailer->send($email);
    }
}