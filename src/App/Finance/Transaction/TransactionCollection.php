<?php

namespace App\Finance\Transaction;

use Ramsey\Uuid\Uuid;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class TransactionCollection
{
    private $id;
    private $debit = [];
    private $credit = [];
    private $orderedTransactions = [];

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function id()
    {
        return $this->id;
    }

    public function bookCredit(Transaction $transaction)
    {
        $this->credit[] = $transaction;
        $this->orderedTransactions = [];
    }

    public function bookDebit(Transaction $transaction)
    {
        $this->debit[] = $transaction;
        $this->orderedTransactions = [];
    }

    public function debit()
    {
        return $this->debit;
    }

    public function credit()
    {
        return $this->credit;
    }

    public function all()
    {
        if (0 === count($this->orderedTransactions)) {
            $transactions = array_merge($this->toArray($this->debit), $this->toArray($this->credit));
            usort($transactions, function (Transaction $a, Transaction $b) {
                if ($a->date() === $b->date()) {
                    return 0;
                }

                return $a->date() > $b->date() ? 1 : -1;
            });
            $this->orderedTransactions = $transactions;
        }

        return $this->orderedTransactions;
    }

    /** @return array */
    private function toArray($arrayOrTraversable)
    {
        return is_array($arrayOrTraversable) ? $arrayOrTraversable : iterator_to_array($arrayOrTraversable);
    }
}
