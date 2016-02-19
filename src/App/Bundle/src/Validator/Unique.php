<?php

namespace App\Bundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Unique extends Constraint
{
    public $message = 'This value already exists in the system.';
    public $field;
    public $class;
    public $normalizer;
    public $em;

    public function validatedBy()
    {
        return 'app.validator.unique';
    }
}
