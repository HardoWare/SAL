<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use http\Message\Body;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly UserRepository $userRepository,
    )
    {}

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMail($subject, $text): void
    {
        $from = getenv("MAILER_ADDRESS");
        $from_name = getenv("MAILER_NAME");
        $andTo = $this->userRepository->getUsersEmail();
        $subject ?? $subject = "System error";
        $text = var_export($text, true);
        $body = $this->prepareBody($text);

        $email = (new Email())
            ->from(new Address($from, $from_name))
            ->to($from)
            ->cc($andTo)
            ->subject($subject)
            ->text($text)
            ->html($body);
        ;
        $this->mailer->send($email);
    }

    private function prepareBody($body)     //TODO: zrobić body do wysłania
    {
        return $body;
    }
}