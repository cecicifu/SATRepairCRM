<?php

namespace App\Validator\Quantity;

use App\Entity\RepairHasProducts;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class QuantityNonZeroValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof QuantityNonZero) {
            throw new UnexpectedTypeException($constraint, QuantityNonZero::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        /* @var RepairHasProducts $hasProduct */
        foreach ($value as $hasProduct) {
            if (0 === $hasProduct->getQuantity()) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $hasProduct->getProduct()->getName())
                    ->addViolation();
            }
        }
    }
}
