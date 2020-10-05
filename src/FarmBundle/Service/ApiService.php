<?php

namespace FarmBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use FarmBundle\Entity\Auction;
use FarmBundle\Entity\Bid;
use FarmBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;

class ApiService
{
    private $em;
    private $twig;

    public function __construct(EntityManagerInterface $em, EngineInterface $twig)
    {
        $this->em = $em;
        $this->twig = $twig;
    }

    /**
     * GET Auction details
     *
     * @param Auction $auction
     *
     * @return array
     */
    public function getAuction(Auction $auction)
    {
        $lastBidder = $this->em->getRepository(Bid::class)->getLastBidForAuction($auction);

        return [
            'auction' => [
                'id'     => $auction->getId(),
                'price'  => $auction->getPrice(),
                'status' => $auction->getStatus(),
            ],
            'bidder' => !$lastBidder ? [] : [
                'name'  => $lastBidder->getBidder()->getUsername(),
                'price' => $lastBidder->getAmount(),
            ],
        ];
    }

    public function buildBidFromRequest(Request $request, Auction $auction)
    {
        $userId = $request->request->get('user');
        $user = $this->em->getRepository(User::class)->find($userId);

        $amount = $request->request->get('amount');

        $bid = new Bid();
        $bid
            ->setAuction($auction)
            ->setAmount($amount)
            ->setBidder($user)
        ;

        return $bid;
    }
}
