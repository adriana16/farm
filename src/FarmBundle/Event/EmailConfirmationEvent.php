<?php

namespace FarmBundle\Event;

use FarmBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class EmailConfirmationEvent extends Event
{
    /** @var User $user */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
