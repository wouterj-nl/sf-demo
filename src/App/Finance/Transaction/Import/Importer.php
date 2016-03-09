<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Finance\Transaction\Import;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
interface Importer
{
    function parseTransactions($source);
}
