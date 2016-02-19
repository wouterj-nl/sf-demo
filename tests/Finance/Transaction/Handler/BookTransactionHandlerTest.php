<?php

namespace App\Finance\Transaction\Handler;

use App\Finance\Transaction\Command\BookTransaction;
use App\Finance\Transaction\TransactionRepository;
use App\Finance\Wallet\WalletRepository;
use App\Finance\Transaction\Transaction;
use App\Finance\Wallet\Wallet;
use App\Finance\Wallet\WalletId;
use Money\Money;
use Prophecy\Argument;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class BookTransactionHandlerTest extends \PHPUnit_Framework_TestCase
{
    private $transactionRepository;
    private $walletRepository;
    private $handler;

    protected function setUp()
    {
        $this->transactionRepository = $this->prophesize(TransactionRepository::class);
        $this->walletRepository = $this->prophesize(WalletRepository::class);
        $this->handler = new BookTransactionHandler($this->transactionRepository->reveal(), $this->walletRepository->reveal());
    }

    public function testPersistsTransactionAndDebitsCreditsWallets()
    {
        $command = new BookTransaction(Money::EUR(1000), new WalletId(1), new WalletId(2), 'Today\'s diner.');

        $wallet1 = $this->prophesize(Wallet::class);
        $wallet1->creditTransaction(Argument::that(function ($transaction) {
            return $transaction instanceof Transaction && Money::EUR(1000) == $transaction->money();
        }))->shouldBeCalled();
        $this->walletRepository->oneById(new WalletId(1))->willReturn($wallet1);

        $wallet2 = $this->prophesize(Wallet::class);
        $wallet2->debitTransaction(Argument::that(function ($transaction) {
            return $transaction instanceof Transaction && Money::EUR(1000) == $transaction->money();
        }))->shouldBeCalled();
        $this->walletRepository->oneById(new WalletId(2))->willReturn($wallet2);

        $this->transactionRepository->persist(Argument::that(function ($transaction) {
            return $transaction instanceof Transaction
                && Money::EUR(1000) == $transaction->money()
                && (new WalletId(1))->equals($transaction->fromWallet())
                && (new WalletId(2))->equals($transaction->toWallet())
                && 'Today\'s diner.' === $transaction->description()
            ;
        }))->shouldBeCalled();

        $this->handler->handle($command);
    }
}
