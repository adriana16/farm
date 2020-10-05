<?php

namespace FarmBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="FarmBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     */
    private $username;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @var string $confirmationToken
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $confirmationToken;

    /**
     * @var bool $enabled
     *
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="FarmBundle\Entity\Box", mappedBy="user", cascade={"persist", "remove"})
     */
    private $boxes;

    /**
     * @ORM\OneToMany(targetEntity="FarmBundle\Entity\Auction", mappedBy="owner", cascade={"persist", "remove"})
     */
    private $auctions;

    /**
     * @ORM\OneToMany(targetEntity="FarmBundle\Entity\Bid", mappedBy="bidder", cascade={"persist", "remove"})
     */
    private $bids;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->enabled = false;
        $this->confirmationToken = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');

        $this->boxes = new ArrayCollection();
        $this->auctions = new ArrayCollection();
        $this->bids = new ArrayCollection();
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param string $confirmationToken
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * @return ArrayCollection
     */
    public function getBoxes()
    {
        return $this->boxes;
    }

    /**
     * @param Box $box
     *
     * @return User
     */
    public function addBox(Box $box)
    {
        $this->boxes->add($box);
        $box->setUser($this);

        return $this;
    }

    /**
     * @param Box $box
     *
     * @return User
     */
    public function removeBox(Box $box)
    {
        $this->boxes->removeElement($box);
        $box->setUser(null);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAuctions()
    {
        return $this->auctions;
    }

    /**
     * @param Auction $auction
     *
     * @return User
     */
    public function addAuction(Auction $auction)
    {
        $this->auctions->add($auction);
        $auction->setOwner($this);

        return $this;
    }

    /**
     * @param Auction $auction
     *
     * @return User
     */
    public function removeAuction(Auction $auction)
    {
        $this->auctions->removeElement($auction);
        $auction->setOwner(null);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBids()
    {
        return $this->bids;
    }

    /**
     * @param Bid $bid
     *
     * @return User
     */
    public function addBid(Bid $bid)
    {
        $this->bids->add($bid);
        $bid->setBidder($this);

        return $this;
    }

    /**
     * @param Bid $bid
     *
     * @return User
     */
    public function removeBid(Bid $bid)
    {
        $this->bids->removeElement($bid);
        $bid->setBidder(null);

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }
}
