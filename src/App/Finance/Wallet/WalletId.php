<?php

namespace App\Finance\Wallet;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class WalletId
{
    private $value;

    public function __construct($value)
    {
        $this->value = (string) $value;
    }

    public function value()
    {
        return $this->value;
    }

    public function equals(WalletId $id)
    {
        return $this->value === $id->value();
    }

    public function __toString()
    {
        return $this->value();
    }
}
