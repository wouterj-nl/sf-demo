<?php

namespace AppBundle\Finance;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
interface Reader
{
    public function retrieveTransactions($source);
}
