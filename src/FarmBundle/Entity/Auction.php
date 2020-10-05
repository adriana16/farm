<?php

namespace FarmBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="auction")
 * @ORM\Entity()
 */
class Auction
{
    const STATUS_CANCELED = 'canceled';
    const STATUS_OPEN = 'open';
    const STATUS_PENDING = 'pending';
    const STATUS_DONE = 'done';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @ORM\Column(name="buy_out_price", type="float")
     */
    private $buyOutPrice;

    /**
     * @ORM\Column(name="step", type="integer")
     */
    private $step;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status = self::STATUS_PENDING;

    /**
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="FarmBundle\Entity\User", inversedBy="auctions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\OneToOne(targetEntity="FarmBundle\Entity\Box", inversedBy="auction")
     * @ORM\JoinColumn(name="box_id", referencedColumnName="id")
     */
    private $box;

    /**
     * @ORM\OneToMany(targetEntity="FarmBundle\Entity\Bid", mappedBy="auction")
     */
    private $bidders;

    public function __construct()
    {
        $this->bidders = new ArrayCollection();
    }

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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return Auction
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float
     */
    public function getBuyOutPrice()
    {
        return $this->buyOutPrice;
    }

    /**
     * @param float $buyOutPrice
     *
     * @return Auction
     */
    public function setBuyOutPrice($buyOutPrice)
    {
        $this->buyOutPrice = $buyOutPrice;

        return $this;
    }

    /**
     * @return integer
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param integer $step
     *
     * @return Auction
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Auction
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return Auction
     */
    public function setStartDate($startDate)
    {
        if ($startDate instanceof \DateTime) {
            $this->startDate = $startDate;
        } else {
            $this->startDate = new \DateTime($startDate);
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     *
     * @return Auction
     */
    public function setEndDate($endDate)
    {
        if ($endDate instanceof \DateTime) {
            $this->endDate = $endDate;
        } else {
            $this->endDate = new \DateTime($endDate);
        }

        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     *
     * @return Auction
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Box
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * @param Box $box
     *
     * @return Auction
     */
    public function setBox($box)
    {
        $this->box = $box;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBidders()
    {
        return $this->bidders;
    }

    /**
     * @param Bid $bid
     *
     * @return Auction
     */
    public function addBid(Bid $bid)
    {
        $this->bidders->add($bid);
        $bid->setAuction($this);

        return $this;
    }

    /**
     * @param Bid $bid
     *
     * @return Auction
     */
    public function removeBid(Bid $bid)
    {
        $this->bidders->removeElement($bid);
        $bid->setAuction(null);

        return $this;
    }
}
