<?php

namespace App\Validator\Quantity;

use App\Entity\RepairHasProducts;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class QuantityLessThanAmountValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        /* @var $constraint QuantityLessThanAmount */

        if (null === $value || '' === $value) {
            return;
        }

		/* @var RepairHasProducts $hasProduct */
        foreach ($value as $hasProduct) {
            if($hasProduct->getQuantity() > $hasProduct->getProduct()->getAmount()) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $hasProduct->getProduct()->getName())
                    ->addViolation();
            }
        }
    }
}
