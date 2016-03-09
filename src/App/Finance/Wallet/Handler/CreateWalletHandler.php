<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Finance\Wallet\Handler;

use App\Finance\Wallet\Command\CreateWallet;
use App\Finance\Wallet\WalletRepository;
use App\Finance\Wallet\Wallet;

/**
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
class CreateWalletHandler
{
    /** @var WalletRepository */
    private $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function handle(CreateWallet $command)
    {
        $method = $command->owner();
        $wallet = Wallet::$method($command->id(), $command->name(), $command->startMoney());

        $this->walletRepository->persist($wallet);
    }
}
