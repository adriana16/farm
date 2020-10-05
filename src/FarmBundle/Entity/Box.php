<?php

namespace FarmBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="box")
 * @ORM\Entity()
 */
class Box
{
    const TYPE_VEGETABLES = 'Vegetables Box';
    const TYPE_FRUITS = 'Fruits Box';
    const TYPE_ALL = 'Combined Box';

    const TYPE_ARR = [
        self::TYPE_VEGETABLES => self::TYPE_VEGETABLES,
        self::TYPE_FRUITS => self::TYPE_FRUITS,
        self::TYPE_ALL => self::TYPE_ALL,
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="FarmBundle\Entity\User", inversedBy="boxes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="FarmBundle\Entity\BoxProduct", mappedBy="box", cascade={"persist", "remove"})
     */
    private $boxProducts;

    /**
     * @ORM\OneToOne(targetEntity="FarmBundle\Entity\Auction", mappedBy="box", cascade={"persist", "remove"})
     */
    private $auction;

    public function __construct()
    {
        $this->boxProducts = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return ArrayCollection
     */
    public function getBoxProducts()
    {
        return $this->boxProducts;
    }

    /**
     * @param BoxProduct $boxProduct
     *
     * @return Box
     */
    public function addBoxProduct(BoxProduct $boxProduct)
    {
        $this->boxProducts->add($boxProduct);
        $boxProduct->setBox($this);

        return $this;
    }

    /**
     * @param BoxProduct $boxProduct
     *
     * @return Box
     */
    public function removeBoxProduct(BoxProduct $boxProduct)
    {
        $this->boxProducts->removeElement($boxProduct);
        $boxProduct->setBox(null);

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
     */
    public function setAuction($auction)
    {
        $this->auction = $auction;
    }
}
