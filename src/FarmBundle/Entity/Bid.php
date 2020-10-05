<?php

namespace FarmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FarmBundle\Validator\Constraints as AppAssert;

/**
 * @ORM\Table(name="bid")
 * @ORM\Entity(repositoryClass="FarmBundle\Repository\BidRepository")
 * @AppAssert\Bid
 */
class Bid
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var Auction
     *
     * @ORM\ManyToOne(targetEntity="FarmBundle\Entity\Auction", inversedBy="bidders")
     * @ORM\JoinColumn(name="auction_id", referencedColumnName="id")
     */
    private $auction;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="FarmBundle\Entity\User", inversedBy="bids")
     * @ORM\JoinColumn(name="bidder_id", referencedColumnName="id")
     */
    private $bidder;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return Bid
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return Bid
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Auction
     */
    public function getAuction()
    {
        return $this->auction;
    }

    /**
     * @param Auction $auction
     *
     * @return Bid
     */
    public function setAuction($auction)
    {
        $this->auction = $auction;

        return $this;
    }

    /**
     * @return User
     */
    public function getBidder()
    {
        return $this->bidder;
    }

    /**
     * @param User $bidder
     *
     * @return Bid
     */
    public function setBidder($bidder)
    {
        $this->bidder = $bidder;

        return $this;
    }
}
