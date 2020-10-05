<?php

namespace FarmBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value->getStartDate() > $value->getEndDate()) {
            $this->context->buildViolation($constraint->message)
                ->setTranslationDomain('messages')
                ->atPath("endDate")
                ->addViolation();
        }
    }
}