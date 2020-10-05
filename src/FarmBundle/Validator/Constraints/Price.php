<?php

namespace FarmBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class Price extends Constraint
{
    public $buyOutPriceMessage = 'Buy Out Price should not be bigger than price';
    public $stepMessage = 'Step should not be bigger than price';

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}
