<?php

namespace App\Finance\Transaction;

use App\Finance\Wallet\WalletId;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
interface TransactionRepository
{
    function persist(Transaction $transaction);

    function forWallet(WalletId $wallet);
}
