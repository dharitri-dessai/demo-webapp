<?php

namespace App\EventListener;

use App\Event\UserRegisteredEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class UserRegisteredListener
{

    public function __construct(private MailerInterface $mailer) {}

    #[AsEventListener(event: UserRegisteredEvent::class)]
    public function onUserRegistered(UserRegisteredEvent $event): void
    {
        $user = $event->getUser();
        $email = (new Email())
        ->from('dharitri11@gmail.com')
        ->to($user->getEmail())
        ->subject('Welcome to Our Website!')
        ->text('Thank you for registering! We are excited to have you on board.');

        $this->mailer->send($email);

    }
}
