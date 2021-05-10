<?php

namespace App\Validator\Quantity;

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

        foreach ($value as $product) {
            if($product->getQuantity() > $product->getProduct()->getAmount()) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $product->getProduct()->getName())
                    ->addViolation();
            }
        }
    }
}
