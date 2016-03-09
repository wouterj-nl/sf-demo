<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Finance\Wallet\Command;

use Money\Money;
use SimpleBus\Message\Name\NamedMessage;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Constructs the system to create a new wallet.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
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
