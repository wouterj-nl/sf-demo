<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bundle\CommandBus;

use App\Bundle\Exception\InvalidCommandException;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * A middleware that validates the Command before
 * handling it.
 *
 * @todo Move this to SimpleBusBundle
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
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
            throw new InvalidCommandException($errors, $message);
        }

        $next($message);
    }
}
