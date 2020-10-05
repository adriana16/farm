<?php

namespace FarmBundle\Controller;

use FarmBundle\Entity\Auction;
use FarmBundle\Entity\Bid;
use FarmBundle\Service\ApiService;
use FarmBundle\Service\AuctionService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuctionAPIController extends Controller
{
    protected $response;
    protected $apiService;
    protected $auctionService;

    public function __construct(ApiService $apiService, AuctionService $auctionService)
    {
        $this->response = new Response();
        $this->apiService = $apiService;
        $this->auctionService = $auctionService;
    }

    /**
     * @Route("/api/auction/{id}", name="api_get_auction", methods={"GET"}, options={"expose": true})
     *
     * @param Auction $auction
     *
     * @return Response
     */
    public function getAction(Auction $auction)
    {
        $response = $this->apiService->getAuction($auction);

//        $this->response->headers->set('Content-Type', 'application/json');
//        $this->response->setContent($response);
//        $this->response->setStatusCode(Response::HTTP_OK);
//
//        return $this->response;

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/auction/{id}", name="api_post_auction", methods={"POST"}, options={"expose": true})
     *
     * @param Auction $auction
     * @param Request $request
     *
     * @return Response
     */
    public function bidAction(Request $request, Auction $auction)
    {
        $bid = $this->apiService->buildBidFromRequest($request, $auction);
        $response = $this->auctionService->bidOnAuction($auction, $bid);

        if (!$response instanceOf Auction) {
            return new JsonResponse($response, 409);
        }

        $response = $this->apiService->getAuction($auction);

        return new JsonResponse($response);
    }
}
