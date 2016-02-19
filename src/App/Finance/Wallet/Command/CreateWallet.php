<?php

namespace App\Finance\Wallet\Command;

use Money\Money;
use SimpleBus\Message\Name\NamedMessage;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class CreateWallet implements NamedMessage
{
    /** @NotBlank */
    private $id;
    /** @NotBlank */
    private $name;
    /** @Choice({"ours", "theirs"}) */
    private $owner;
    /** @var Money */
    private $startMoney;

    public function __construct($id, $name, $owner, $startMoney = null)
    {
        if (null === $startMoney) {
            $startMoney = Money::EUR(0);
        }

        $this->id = $id;
        $this->name = $name;
        $this->owner = $owner;
        $this->startMoney = $startMoney;
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function owner()
    {
        return $this->owner;
    }

    public function startMoney()
    {
        return $this->startMoney;
    }

    public static function messageName()
    {
        return 'create_wallet';
    }
}
