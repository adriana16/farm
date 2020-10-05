<?php

namespace FarmBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FarmBundle\Entity\Auction;
use FarmBundle\Entity\Bid;

class BidRepository extends EntityRepository
{
    /**
     * @param Auction $auction
     *
     * @return Bid
     */
    public function getLastBidForAuction(Auction $auction)
    {
        $qb = $this->createQueryBuilder('bid');

        $qb
            ->where($qb->expr()->eq('IDENTITY(bid.auction)', ':auction'))
            ->setParameter('auction', $auction->getId())
            ->orderBy('bid.id', 'DESC')
            ->setMaxResults(1)
        ;

        return $qb
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
