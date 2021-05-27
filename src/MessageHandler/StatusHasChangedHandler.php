<?php

namespace App\MessageHandler;

use App\Message\StatusHasChanged;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

final class StatusHasChangedHandler implements MessageHandlerInterface
{
    private LoggerInterface $logger;
    private MailerInterface $mailer;

    public function __construct(LoggerInterface $logger, MailerInterface $mailer)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
    }

    public function __invoke(StatusHasChanged $message): void
    {
        try {
            $email = (new TemplatedEmail())
                ->from(Address::create('SATRepairCRM <status@satrepaircrm.me>'))
                ->to($message->getEmail())
                ->priority(Email::PRIORITY_NORMAL)
                ->subject("Repair status updated {$message->getCode()}")
                ->htmlTemplate('email/status_has_changed.html.twig')
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
