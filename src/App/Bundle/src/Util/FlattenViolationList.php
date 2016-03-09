<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bundle\Util;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * A small utility to flatten a list of constraint violations.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
class FlattenViolationList
{
    /** @var ConstraintViolationListInterface */
    private $constraintViolations;

    public function __construct(ConstraintViolationInterface $constraintViolations)
    {
        $this->constraintViolations = $constraintViolations;
    }

    public function toArray()
    {
        $errors = [];

        foreach ($this->constraintViolations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}
