<?php

namespace FarmBundle\Service;

use FarmBundle\Entity\User;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class EmailService
{
    private $mailer;
    private $twig;
    private $router;
    private $fromEmailAddress;

    public function __construct(
        \Swift_Mailer $mailer,
        EngineInterface $twig,
        RouterInterface $router,
        string $fromEmailAddress
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->router = $router;
        $this->fromEmailAddress = $fromEmailAddress;
    }

    /**
     * Send confirmation email after registration
     *
     * @param User $user
     */
    public function sentUserRegistrationEmail(User $user)
    {
        $mailTo = $user->getEmail();

        $body = $this->twig->render('emails/confirmation_email.html.twig', [
            'user'            => $user,
            'confirmationUrl' => $this->router->generate(
                'user_confirmation',
                ['token' => $user->getConfirmationToken()],
                RouterInterface::ABSOLUTE_URL),
        ]);

        $message = \Swift_Message::newInstance();
        $message
            ->setSubject('Welcome to our farm app!')
            ->setFrom($this->fromEmailAddress)
            ->setTo($mailTo)
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}
