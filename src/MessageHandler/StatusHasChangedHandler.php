<?php

namespace App\MessageHandler;

use App\Message\StatusHasChanged;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

final class StatusHasChangedHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(StatusHasChanged $message): void
    {
        $email = (new Email())
            ->from(Address::create('SATRepairCRM <status@satrepaircrm.me>'))
            ->to($message->getEmail())
            ->priority(Email::PRIORITY_NORMAL)
            ->subject("Repair Status Update {$message->getCode()}")
            ->html("
				Your repair status ({$message->getCode()}) has been updated to <b>{$message->getStatus()}.</b>
				<i>This e-mail is an automatic confirmation. Please do not reply to it.</i>
			")
        ;

        $email
            ->getHeaders()
            ->addTextHeader('X-Auto-Response-Suppress', 'All')
        ;

        $this->mailer->send($email);
    }
}
