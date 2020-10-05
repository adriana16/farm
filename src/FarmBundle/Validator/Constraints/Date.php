<?php

namespace FarmBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class Date extends Constraint
{
    public $message = 'End Date should be grater or equal with Start Date.';
}