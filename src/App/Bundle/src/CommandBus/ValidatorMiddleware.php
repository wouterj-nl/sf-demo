<?php

namespace App\Bundle\CommandBus;

use App\Bundle\Exception\InvalidCommandException;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class ValidatorMiddleware implements MessageBusMiddleware
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function handle($message, callable $next)
    {
        $errors = $this->validator->validate($message);

        if (0 !== count($errors)) {
            throw new InvalidCommandException($errors);
        }

        $next($message);
    }
}
