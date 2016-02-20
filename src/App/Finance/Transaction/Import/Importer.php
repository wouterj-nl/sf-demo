<?php

namespace App\Finance\Transaction\Import;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
interface Importer
{
    function parseTransactions($source);
}
