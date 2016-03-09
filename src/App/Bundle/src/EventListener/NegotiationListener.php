<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bundle\EventListener;

use Negotiation\Negotiator;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * A listener that sets the request format using Negotiation.
 *
 * This is mostly usefull to get Symfony errors in the correct
 * format.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
class NegotiationListener
{
    /** @var Negotiator */
    private $negotiator;

    public function __construct(Negotiator $negotiator)
    {
        $this->negotiator = $negotiator;
    }

    public function configureContentType(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (null !== $request->getRequestFormat(null)) {
            return;
        }

        $accept = $request->headers->get('Accept');
        $mediaType = $this->negotiator->getBest($accept, ['application/json', 'text/html']);

        $request->setRequestFormat($mediaType->getSubPart());
    }
}
