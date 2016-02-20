<?php

namespace App\Finance\Transaction\Import;

use App\Finance\Wallet\Wallet;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class ImportedTransaction
{
    /** @var Uuid */
    private $id;
    /** @var Money */
    private $money;
    /** @var string */
    private $description;
    /** @var \DateTime */
    private $date;
    /** @var Wallet */
    private $from;
    /** @var Wallet */
    private $to;
    private $extra = [];

    private function __construct(UuidInterface $id, Money $money, $description, \DateTime $date)
    {
        $this->id = $id;
        $this->money = $money;
        $this->description = $description;
        $this->date = $date;
    }

    public static function import(Money $money, $description, \DateTime $date, array $extra = [])
    {
        $transaction = new self(Uuid::uuid4(), $money, $description, $date);
        $transaction->extra = $extra;

        return $transaction;
    }

    public function setFromWallet(Wallet $wallet)
    {
        $this->from = $wallet;
    }

    public function setToWallet(Wallet $wallet)
    {
        $this->to = $wallet;
    }

    public function id()
    {
        return $this->id;
    }

    public function money()
    {
        return $this->money;
    }

    public function description()
    {
        return $this->description;
    }

    /** @return Wallet */
    public function from()
    {
        return $this->from;
    }

    public function to()
    {
        return $this->to;
    }

    public function extra()
    {
        return $this->extra;
    }
}
