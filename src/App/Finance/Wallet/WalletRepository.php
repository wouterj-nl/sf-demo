<?php

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
