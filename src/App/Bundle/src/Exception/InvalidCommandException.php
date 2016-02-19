<?php

namespace App\Bundle\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Wouter J <wouter@wouterj.nl>
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

        parent::__construct('Validation failed for this command.', $code);
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
