<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Finance\Transaction\Handler;

use App\Finance\Transaction\Command\BookTransaction;
use App\Finance\Transaction\TransactionRepository;
use App\Finance\Wallet\WalletRepository;
use App\Finance\Transaction\Transaction;

/**
 * This command contains the logic to handle a BookTranscation
 * command.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
class BookTransactionHandler
{
    /** @var TransactionRepository */
    private $transactionRepository;
    /** @var WalletRepository */
    private $walletRepository;

    public function __construct(TransactionRepository $transactionRepository, WalletRepository $walletRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
    }

    public function handle(BookTransaction $command)
    {
        // First, fetch the wallets referenced by the new transaction.
        $fromWallet = $this->walletRepository->oneById($command->from());
        $toWallet = $this->walletRepository->oneById($command->to());

        // Then, book a new Transaction from a Wallet to another one.
        $transaction = Transaction::book($command->id(), $command->money(), $fromWallet, $toWallet, $command->date(), $command->description());
        $this->transactionRepository->persist($transaction);

        // Finally, notify both wallets a transaction occurred from/to
        // them.
        $fromWallet->bookCredit($transaction);
        $toWallet->bookDebit($transaction);

        $this->walletRepository->flush();
    }
}
