<?php

namespace App\Finance\Transaction\Command;

use App\Finance\Transaction\BankAccount;
use App\Finance\Wallet\WalletId;
use Money\Money;
use Ramsey\Uuid\Uuid;
use SimpleBus\Message\Name\NamedMessage;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class BookTransaction implements NamedMessage
{
    /** @var Uuid */
    private $id;
    /** @var Money */
    private $money;
    /** @var WalletId */
    private $from;
    /** @var WalletId */
    private $to;
    /** @var string */
    private $description;
    private $date;

    public function __construct(Uuid $id, Money $money, WalletId $from, WalletId $to, \DateTime $date, $description)
    {
        $this->id = $id;
        $this->money = $money;
        $this->from = $from;
        $this->to = $to;
        $this->description = $description;
        $this->date = $date;
    }

    public function id()
    {
        return $this->id;
    }

    public function money()
    {
        return $this->money;
    }

    public function from()
    {
        return $this->from;
    }

    public function to()
    {
        return $this->to;
    }

    public function date()
    {
        return $this->date;
    }

    public function description()
    {
        return $this->description;
    }

    public static function messageName()
    {
        return 'book_transaction';
    }
}
