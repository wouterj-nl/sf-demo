<?php

namespace App\Finance\Transaction\Handler;

use App\Finance\Transaction\Command\BookTransaction;
use App\Finance\Transaction\TransactionRepository;
use App\Finance\Wallet\WalletRepository;
use App\Finance\Transaction\Transaction;


/**
 * @author Wouter J <wouter@wouterj.nl>
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
        $fromWallet = $this->walletRepository->oneById($command->from());
        $toWallet = $this->walletRepository->oneById($command->to());

        $transaction = Transaction::book($command->id(), $command->money(), $fromWallet, $toWallet, $command->date(), $command->description());
        $this->transactionRepository->persist($transaction);

        $fromWallet->bookCredit($transaction);
        $toWallet->bookDebit($transaction);

        $this->walletRepository->flush();
    }
}
