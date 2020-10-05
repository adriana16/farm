<?php

namespace FarmBundle\Controller;

use FarmBundle\Entity\Box;
use FarmBundle\Form\BoxType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoxController extends Controller
{
    /**
     * @Route("/box", name="box_index", methods={"GET"}, options={"expose": true})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $boxes = $this->getDoctrine()->getRepository(Box::class)->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render(':box:index.html.twig', [
            'boxes' => $boxes,
        ]);
    }

    /**
     * @Route("/box/{id}/view", name="box_view", methods={"GET"}, options={"expose": true})
     *
     * @param Request $request
     * @param Box $box
     *
     * @return Response
     */
    public function viewAction(Request $request, Box $box)
    {
        return $this->render('box/view.html.twig', [
            'box' => $box,
        ]);
    }

    /**
     * @Route("/box/new", name="box_new", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request)
    {
        $box = new Box();
        $form = $this->createForm(BoxType::class, $box);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $box->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($box);
            $entityManager->flush();

            return $this->redirectToRoute('box_index');
        }

        return $this->render('box/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/box/{id}/edit", name="box_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Box $box
     *
     * @return Response
     */
    public function editAction(Request $request, Box $box)
    {
        $form = $this->createForm(BoxType::class, $box);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($box);
            $entityManager->flush();

            return $this->redirectToRoute('box_index');
        }

        return $this->render('box/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/box/{id}", name="box_remove", methods={"DELETE"}, options={"expose": true})
     *
     * @param Request $request
     * @param Box $box
     *
     * @return JsonResponse
     */
    public function removeAction(Request $request, Box $box)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($box);
        $entityManager->flush();

        return new JsonResponse([
            'status' => 'success',
        ]);
    }
}