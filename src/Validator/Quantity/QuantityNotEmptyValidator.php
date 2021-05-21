<?php

namespace App\Validator\Quantity;

use App\Entity\RepairHasProducts;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class QuantityNotEmptyValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        /* @var $constraint QuantityNotEmpty */

        if (null === $value || '' === $value) {
            return;
        }

		/* @var RepairHasProducts $hasProduct */
        foreach ($value as $hasProduct) {
            if ($hasProduct->getQuantity() === null ) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $hasProduct->getProduct()->getName())
                    ->addViolation();
            }
        }
    }
}
