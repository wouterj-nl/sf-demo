<?php

namespace App\Bundle\View;

use App\Finance\Wallet\WalletId;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Transaction
{
    public $money;
    public $description;
    public $isDebit;

    public function __construct($money, $description, $isDebit)
    {
        $this->money = $money;
        $this->description = $description;
        $this->isDebit = $isDebit;
    }

    public static function fromEntity(\App\Finance\Transaction\Transaction $transaction, WalletId $wallet)
    {
        return new self(
            $transaction->money()->getCurrency().' '.($transaction->money()->getAmount() / 100),
            $transaction->description(),
            $transaction->to()->id()->equals($wallet)
        );
    }

    public static function fromEntities(array $transactions, WalletId $id)
    {
        $transformed = [];
        foreach ($transactions as $transaction) {
            $transformed[] = self::fromEntity($transaction, $id);
        }

        return $transformed;
    }
}
