<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bundle\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * An exception that's thrown by the CommandBus ValidatorMiddleware
 * when a command was invalid.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
class InvalidCommandException extends \RuntimeException
{
    /** @var ConstraintViolationListInterface */
    private $violationList;
    private $command;

    public function __construct(ConstraintViolationListInterface $violationList, $command, $code = 0)
    {
        $this->violationList = $violationList;
        $this->command = $command;

        parent::__construct('Validation failed for the `'.$command.'` command.', $code);
    }

    public function command()
    {
        return $this->command;
    }

    public function violations()
    {
        return $this->violationList;
    }
}
