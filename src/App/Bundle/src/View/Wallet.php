<?php

namespace App\Bundle\View;

use Ramsey\Uuid\Uuid;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Wallet
{
    public $id;
    public $name;
    public $money;
    public $transactions;
    public $bookUrl;

    public function __construct($id, $name, $money, $transactions)
    {
        $this->id = $id;
        $this->name = $name;
        $this->money = $money;
        $this->transactions = $transactions;
    }

    public static function fromEntity(\App\Finance\Wallet\Wallet $wallet, array $transactions)
    {
        return new self(
            Uuid::fromString($wallet->id()->value())->getHex(),
            $wallet->name(),
            $wallet->money()->getCurrency().' '.($wallet->money()->getAmount() / 100),
            $transactions
        );
    }
}
