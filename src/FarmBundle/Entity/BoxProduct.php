<?php

namespace FarmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="box_product")
 * @ORM\Entity()
 */
class BoxProduct
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="FarmBundle\Entity\Box", inversedBy="boxProducts")
     * @ORM\JoinColumn(name="box_id", referencedColumnName="id")
     */
    private $box;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     *  @return BoxProduct
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param integer $quantity
     *
     * @return BoxProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

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
     * @return BoxProduct
     */
    public function setBox($box)
    {
        $this->box = $box;

        return $this;
    }
}
