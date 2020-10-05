<?php

namespace FarmBundle\EventListener;

use FarmBundle\Event\EmailConfirmationEvent;
use FarmBundle\Service\EmailService;

class EmailConfirmationListener
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function onUserRegister(EmailConfirmationEvent $event)
    {
        $user = $event->getUser();

        $this->emailService->sentUserRegistrationEmail($user);
    }
}
