<?php

namespace AppBundle\Finance;

use Money\Money;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="transactions")
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /** @ORM\Column(type="string", length=255) */
    private $description;
    /**
     * @ORM\Embedded(class="Money\Money")
     *
     * @var Money
     */
    private $money;
    /**
     * @ORM\ManyToOne(targetEntity="BankAccount", cascade={"persist"})
     * @ORM\JoinColumn(name="from_account_id", referencedColumnName="number")
     *
     * @var BankAccount
     */
    private $fromAccount;
    /**
     * @ORM\ManyToOne(targetEntity="BankAccount", cascade={"persist"})
     * @ORM\JoinColumn(name="to_account_id", referencedColumnName="number")
     *
     * @var BankAccount
     */
    private $toAccount;
    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $time;
    /**
     * @ORM\Column(type="string", length=2)
     *
     * @var string|TransactionType
     */
    private $type;

    /**
     * Transaction constructor.
     *
     * @param string $description
     */
    public function __construct($description)
    {
        $this->description = $description;
    }

    public function amount(Money $money)
    {
        $transaction = clone $this;
        $transaction->money = $money;

        return $transaction;
    }

    public function from(BankAccount $account)
    {
        $transaction = clone $this;
        $transaction->fromAccount = $account;

        return $transaction;
    }

    public function to(BankAccount $account = null)
    {
        $transaction = clone $this;
        $transaction->toAccount = $account;

        return $transaction;
    }

    public function at(\DateTime $time)
    {
        $transaction = clone $this;
        $transaction->time = $time;

        return $transaction;
    }

    public function using(TransactionType $type)
    {
        $transaction = clone $this;
        $transaction->type = $type;

        return $transaction;
    }

    public function description()
    {
        return $this->description;
    }

    public function money()
    {
        return $this->money;
    }

    public function fromAccount()
    {
        return $this->fromAccount;
    }

    public function toAccount()
    {
        return $this->toAccount;
    }

    public function time()
    {
        return $this->time;
    }

    /**
     * @return TransactionType
     */
    public function type()
    {
        if (!$this->type instanceof TransactionType) {
            $this->type = TransactionType::fromCode($this->type);
        }

        return $this->type;
    }

    public function isIncome()
    {
        return null !== $this->toAccount && !$this->toAccount->holder();
    }
}
