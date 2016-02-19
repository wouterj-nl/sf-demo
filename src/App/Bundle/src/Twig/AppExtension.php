<?php

namespace App\Bundle\Twig;

use App\Finance\Transaction\Transaction;
use App\Finance\Wallet\WalletId;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class AppExtension extends \Twig_Extension
{
    public function getTests()
    {
        return [
            new \Twig_SimpleTest('debit', [$this, 'isDebit']),
        ];
    }

    public function isDebit(Transaction $transaction, WalletId $walletId)
    {
        return $transaction->fromWallet()->equals($walletId);
    }

    public function getName()
    {
        return 'app';
    }
}
