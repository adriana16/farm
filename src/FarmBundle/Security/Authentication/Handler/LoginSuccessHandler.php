<?php

namespace FarmBundle\Security\Authentication\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var RouterInterface $router
     */
    private $router;

    /** @var AuthorizationCheckerInterface $authorizationChecker */
    private $authorizationChecker;

    public function __construct(
        RouterInterface $router,
        AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // Default target for unknown roles. Everyone else go there.
        $url = 'homepage';

        if ($this->authorizationChecker->isGranted('ROLE_FARMER')) {
            $url = 'homepage_farmer';
        } elseif ($this->authorizationChecker->isGranted('ROLE_BUYER')) {
            $url = 'homepage';
        }

        $response = new RedirectResponse($this->router->generate($url));

        return $response;
    }
}
