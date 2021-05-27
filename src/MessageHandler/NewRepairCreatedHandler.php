<?php

namespace App\MessageHandler;

use App\Message\NewRepairCreated;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

final class NewRepairCreatedHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, MailerInterface $mailer)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
    }

    public function __invoke(NewRepairCreated $message): void
    {
        try {
            $email = (new TemplatedEmail())
                ->from(Address::create('SATRepairCRM <status@satrepaircrm.me>'))
                ->to($message->getEmail())
                ->priority(Email::PRIORITY_NORMAL)
                ->subject("New repair created {$message->getCode()}")
                ->htmlTemplate('email/new_repair_created.html.twig')
                ->context(['message' => $message])
            ;

            $email
                ->getHeaders()
                ->addTextHeader('X-Auto-Response-Suppress', 'All')
            ;

            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e);
        }
    }
}
