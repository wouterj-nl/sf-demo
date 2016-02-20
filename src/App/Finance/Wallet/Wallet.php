<?php

namespace App\Finance\Wallet;

use App\Finance\Transaction\Transaction;
use App\Finance\Wallet\WalletId;
use Doctrine\Common\Collections\ArrayCollection;
use Money\Money;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Wallet
{
    /** @var WalletId */
    private $id;
    /** @var string */
    private $name;
    /** @var Money */
    private $money;
    /** @var bool */
    private $own = true;

    private function __construct(WalletId $id, $name, Money $money)
    {
        $this->id = $id;
        $this->name = $name;
        $this->money = $money;
    }

    public static function ours($id, $name, Money $money)
    {
        return new static(new WalletId($id), $name, $money);
    }

    public static function theirs($id, $name, Money $money)
    {
        $wallet = new static(new WalletId($id), $name, $money);
        $wallet->own = false;

        return $wallet;
    }

    public function bookCredit(Transaction $transaction)
    {
        $this->money = $this->money->subtract($transaction->money());
    }

    public function bookDebit(Transaction $transaction)
    {
        $this->money = $this->money->add($transaction->money());
    }

    /** @return WalletId */
    public function id()
    {
        if (!$this->id instanceof WalletId) {
            $this->id = new WalletId($this->id);
        }

        return $this->id;
    }

    /** @return Money */
    public function money()
    {
        return $this->money;
    }

    /** @return string */
    public function name()
    {
        return $this->name;
    }

    /** @return bool */
    public function isOurs()
    {
        return $this->own;
    }
}
