<?php

namespace App\Validator\Quantity;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class QuantityNonZeroValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        /* @var $constraint QuantityNonZero */

        if (null === $value || '' === $value) {
            return;
        }

        foreach ($value as $product) {
            if($product->getQuantity() === 0) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $product->getProduct()->getName())
                    ->addViolation();
            }
        }
    }
}
