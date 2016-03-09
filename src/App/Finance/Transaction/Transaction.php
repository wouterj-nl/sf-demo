<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Finance\Transaction;

use App\Finance\Wallet\Wallet;
use Money\Money;
use Ramsey\Uuid\Uuid;

/**
 * Represents a money transaction from one wallet to another.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
class Transaction
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

    // This constructor is not public, as we cannot create
    // transactions; the user booked a transaction.
    // http://verraes.net/2014/06/named-constructors-in-php/
    private function __construct(Uuid $id, Money $money, Wallet $from, Wallet $to, \DateTime $date, $description)
    {
        $this->id = $id;
        $this->money = $money;
        $this->date = $date;
        $this->description = $description;
        $this->from = $from;
        $this->to = $to;
    }

    public static function book(Uuid $id, Money $money, Wallet $from, Wallet $to, \DateTime $date, $description)
    {
        return new static($id, $money, $from, $to, $date, $description);
    }

    public function id()
    {
        return $this->id;
    }

    public function date()
    {
        return $this->date;
    }

    /** @return Money */
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
}
