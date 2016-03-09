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
use Ramsey\Uuid\Uuid;

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
        $command = new BookTransaction(
            Uuid::uuid4(),
            Money::EUR(1000),
            new WalletId(1),
            new WalletId(2),
            new \DateTime(),
            'Today\'s diner.'
        );


        $wallet1 = $this->getWalletProphet(Money::EUR(1000));
        $this->walletRepository->oneById(new WalletId(1))->willReturn($wallet1);

        $wallet2 = $this->getWalletProphet(Money::EUR(1000), false);
        $this->walletRepository->oneById(new WalletId(2))->willReturn($wallet2);

        $this->walletRepository->flush()->shouldBeCalled();

        $this->transactionRepository->persist(Argument::that(function ($transaction) use ($wallet1, $wallet2) {
            return $transaction instanceof Transaction
                && Money::EUR(1000) == $transaction->money()
                && $wallet1 === $transaction->from()
                && $wallet2 === $transaction->to()
                && 'Today\'s diner.' === $transaction->description()
            ;
        }))->shouldBeCalled();

        $this->handler->handle($command);
    }

    private function getWalletProphet(Money $money, $credit = true)
    {
        $wallet = $this->prophesize(Wallet::class);
        $argProphet = Argument::that(function ($transaction) use ($money) {
            return $transaction instanceof Transaction && $money == $transaction->money();
        });

        if ($credit) {
            $wallet->bookCredit($argProphet)->shouldBeCalled();
        } else {
            $wallet->bookDebit($argProphet)->shouldBeCalled();
        }

        return $wallet->reveal();
    }
}
