<?php

namespace FarmBundle\Controller;

use FarmBundle\Entity\Auction;
use FarmBundle\Entity\Bid;
use FarmBundle\Entity\Box;
use FarmBundle\Form\AuctionType;
use FarmBundle\Form\BidType;
use FarmBundle\Service\AuctionService;
use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuctionController extends Controller
{
    /**
     * @Route("/auctions", name="auction_index", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        if ($user->hasRole("ROLE_FARMER")) {
            $auctions = $this->getDoctrine()->getRepository(Auction::class)->findBy([
                'owner' => $this->getUser()
            ]);
        } else {
            $auctions = $this->getDoctrine()->getRepository(Auction::class)->findBy([
                'status' => [Auction::STATUS_PENDING, Auction::STATUS_OPEN]
            ]);
        }

        return $this->render('auction/index.html.twig', [
            'auctions' => $auctions
        ]);
    }

    /**
     * @Route("/auction/{id}/view", name="auction_view", methods={"GET", "POST"}, options={"expose": true})
     *
     * @param Request $request
     * @param Auction $auction
     *
     * @return Response|JsonResponse
     */
    public function viewAction(
        Request $request,
        Auction $auction
    ) {
        $bid = new Bid();
        $bid
            ->setAuction($auction)
            ->setBidder($this->getUser())
        ;

        $bidForm = $this->createForm(BidType::class, $bid, [
            'auction' => $auction,
        ]);

        return $this->render('auction/view.html.twig', [
            'auction' => $auction,
            'user'    => $this->getUser(),
            'bidForm' => $bidForm->createView(),
        ]);
    }

    /**
     * @Route("/auction/{id}/new", name="auction_new", methods={"GET", "POST"}, options={"expose": true})
     *
     * @param Request $request
     * @param Box $box
     *
     * @return Response
     */
    public function newAction(Request $request, Box $box)
    {
        $auction = new Auction();
        $form = $this->createForm(AuctionType::class, $auction);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $auction->setBox($box);
            $auction->setOwner($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($auction);
            $entityManager->flush();

            return $this->redirectToRoute('box_index');
        }

        return $this->render('auction/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/auction/{id}/toggle", name="auction_toggle", methods={"GET", "POST"}, options={"expose": true})
     *
     * @param Request $request
     * @param Auction $auction
     *
     * @return RedirectResponse
     */
    public function toggleStatusAction(Request $request, Auction $auction)
    {
        $em = $this->getDoctrine()->getManager();

        if ($auction->getStatus() !== Auction::STATUS_OPEN) {
            $auction->setStatus(Auction::STATUS_OPEN);
            $auction->setStartDate(new \DateTime('now'));
        } else {
            $auction->setStatus(Auction::STATUS_DONE);
            $auction->setEndDate(new \DateTime('now'));
        }

        $em->persist($auction);
        $em->flush();

        return $this->redirectToRoute('auction_view', ['id' => $auction->getId()]);
    }
}
