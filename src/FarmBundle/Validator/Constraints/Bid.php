<?php

namespace FarmBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Bid
 * @package FarmBundle\Validator\Constraints
 * @Annotation
 */
class Bid extends Constraint
{
    public $expiredMessage = 'This Auction is not available for bidding';
    public $amountMessage = 'Bid amount must be grater than {{ value }}';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}