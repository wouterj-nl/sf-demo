<?php

namespace AppBundle\Finance;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bank_accounts")
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
class BankAccount
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=18)
     */
    private $number;
    /** @ORM\Column(type="string", length=4) */
    private $bank;
    /** @ORM\Column(type="string", length=100, nullable=true) */
    private $holder;

    public static function fromIban($iban, $holder = null)
    {
        $account = new static();
        $account->number = $iban;
        $account->bank = substr($iban, 4, 4);
        $account->holder = $holder;

        return $account;
    }

    public function number()
    {
        return $this->number;
    }

    public function holder()
    {
        return $this->holder;
    }
}
