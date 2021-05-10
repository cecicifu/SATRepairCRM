<?php

namespace App\Validator\Quantity;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class QuantityPositive extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public string $message = 'The quantity of "{{ value }}" cannot be negative.';
}
