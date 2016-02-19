<?php

namespace App\Finance\Transaction\Handler;

use App\Finance\Wallet\Command\CreateWallet;
use App\Finance\Wallet\Handler\CreateWalletHandler;
use App\Finance\Wallet\WalletRepository;
use App\Finance\Wallet\Wallet;
use App\Finance\Wallet\WalletId;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Prophecy\Argument;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class CreateWalletHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @var WalletRepository */
    private $repository;
    /** @var CreateWalletHandler */
    private $handler;

    protected function setUp()
    {
        $this->repository = $this->prophesize(WalletRepository::class);
        $this->handler = new CreateWalletHandler($this->repository->reveal());
    }

    /** @dataProvider getPersistsNewWalletsData */
    public function testPersistsNewWallets($ours, $startMoney = null)
    {
        $command = new CreateWallet($id = Uuid::uuid4(), 'Food & drinks', $ours ? 'ours' : 'theirs', $startMoney);

        $this->repository->persist(Argument::that(function ($wallet) use ($id, $ours, $startMoney) {
            return $wallet instanceof Wallet
                && (new WalletId($id))->equals($wallet->id())
                && $ours === $wallet->isOurs()
                && ($startMoney ?: Money::EUR(0)) == $wallet->money()
                && 'Food & drinks' === $wallet->name()
            ;
        }))->shouldBeCalled();

        $this->handler->handle($command);
    }

    public function getPersistsNewWalletsData()
    {
        return [
            [true],
            [false],
            [true, Money::EUR(1000)],
        ];
    }
}
