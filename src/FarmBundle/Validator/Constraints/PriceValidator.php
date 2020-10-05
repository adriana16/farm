<?php

namespace FarmBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PriceValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value->getBuyOutPrice() > $value->getPrice()) {
            $this->context->buildViolation($constraint->buyOutPriceMessage)
                ->setTranslationDomain('messages')
                ->atPath("buyOutPrice")
                ->addViolation();
        }

        if ($value->getStep() > $value->getPrice()) {
            $this->context->buildViolation($constraint->stepMessage)
                ->setTranslationDomain('messages')
                ->atPath("step")
                ->addViolation();
        }
    }
}
