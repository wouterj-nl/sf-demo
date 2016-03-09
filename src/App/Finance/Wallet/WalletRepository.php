<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Finance\Wallet;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
interface WalletRepository
{
    function persist(Wallet $wallet);

    /** @return Wallet */
    function oneById(WalletId $id);

    /** @return Wallet[] */
    function all();

    function flush();
}
