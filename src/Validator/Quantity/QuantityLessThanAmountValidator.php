<?php

namespace App\Validator\Quantity;

use App\Entity\RepairHasProducts;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class QuantityLessThanAmountValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
		if (!$constraint instanceof QuantityLessThanAmount) {
			throw new UnexpectedTypeException($constraint, QuantityLessThanAmount::class);
		}

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
