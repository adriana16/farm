<?php

namespace FarmBundle\Controller;

use FarmBundle\Entity\User;
use FarmBundle\Form\UserType;
use FarmBundle\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/register", name="user_registration", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->registerUser($user);

            return $this->redirectToRoute('user_registration_check');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Tell the user to check their email provider.
     *
     * @Route("/register/check", name="user_registration_check", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function checkEmailAction(Request $request)
    {
        return $this->render('registration/register_check.html.twig');
    }

    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @Route("/confirmation", name="user_confirmation", methods={"GET"})
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function confirmAction(Request $request)
    {
        $user = $this->userService->confirmRegistrationRequest($request);

        if (null === $user) {
            return new RedirectResponse($this->get('router')->generate('user_login'));
        }

        return $this->redirectToRoute('homepage');
    }
}
