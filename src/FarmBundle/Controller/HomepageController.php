<?php

namespace FarmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('homepage/index.html.twig');
    }

    /**
     * @Route("/farmer", name="homepage_farmer")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function farmerAction(Request $request)
    {
        return $this->render('homepage/farmer.html.twig');
    }
}
