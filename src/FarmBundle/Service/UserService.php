<?php

namespace FarmBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use FarmBundle\Entity\User;
use FarmBundle\Event\EmailConfirmationEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserService
{
    private $entityManager;
    private $tokenStorage;
    private $session;
    private $eventDispatcher;
    private $passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        SessionInterface $session,
        EventDispatcherInterface $eventDispatcher,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->eventDispatcher = $eventDispatcher;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function registerUser(User $user)
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        //Send user email confirmation
        $this->eventDispatcher->dispatch("user_registered", new EmailConfirmationEvent($user));

        return $user;
    }

    public function confirmRegistrationRequest(Request $request): ?User
    {
        $token = $request->get('token');

        if (null === $token) {
            return null;
        }

        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->findOneByConfirmationToken($token);

        if (null === $user) {
            return null;
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);

        $this->session->set('_security_main', serialize($token));

        $event = new InteractiveLoginEvent($request, $token);
        $this->eventDispatcher->dispatch("security.interactive_login", $event);

        return $user;
    }
}
