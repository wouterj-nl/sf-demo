<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bundle\Controller;

use App\Bundle\Exception\InvalidCommandException;
use App\Bundle\Util\FlattenViolationList;
use App\Finance\Transaction\Transaction;
use App\Finance\Wallet\Command\CreateWallet;
use App\Finance\Wallet\Wallet;
use App\Finance\Wallet\WalletId;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
class WalletController extends Controller
{
    // the "Action" suffix for controllers/actions are just
    // conventions required when using the Bundle:Controller:action
    // format. As we're using the annotations, we are free
    // to call the methods anything we want.

    /**
     * @Route("/api/wallets", name="create_wallet")
     * @Method("POST")
     */
    public function create(Request $request)
    {
        // Construct a new command for the domain layer to execute.
        // We save the id of the new wallet, so we can use it later
        // to fetch the information.
        $command = new CreateWallet($id = Uuid::uuid4(), $request->request->get('name'), $request->request->get('owner'));

        try {
            $this->get('command_bus')->handle($command);
        } catch (InvalidCommandException $e) {
            // If the command contains invalid values (in other words,
            // the user filled in something incorrectly), this exception
            // is thrown and we return a nice list of the errors.
            //
            // @todo it would be nicer to use a kernel.exception listener for this.
            //       http://symfony.com/doc/current/components/http_kernel/introduction#handling-exceptions-the-kernel-exception-event
            return new JsonResponse([
                'errors' => (new FlattenViolationList($e->violations()))->toArray(),
            ], 400);
        }

        return new JsonResponse(['wallet_id' => $id], 201);
    }

    // These methods do nothing more than fetching the
    // Wallet objects and formatting them in a JSON response.

    /** @Route("/api/wallets", name="get_wallets") */
    public function all()
    {
        return new JsonResponse(array_map(
            [$this, 'formatWallet'],
            $this->get('app.repository.wallet')->all()
        ));
    }

    /** @Route("/api/wallets/{id}/transactions", name="wallet_transactions") */
    public function transactions($id)
    {
        $wallet = new WalletId(Uuid::fromString($id));

        return new JsonResponse(array_map(
            [$this, 'formatTransaction'],
            $this->get('app.repository.transaction')->forWallet($wallet)
        ));
    }

    // @todo These methods do not belong in a controller and the
    //       serializer should be used instead.
    //       http://symfony.com/doc/current/components/serializer

    private function formatTransaction(Transaction $transaction)
    {
        return [
            'id'          => (string) $transaction->id(),
            'date'        => $transaction->date()->format('c'),
            'description' => $transaction->description(),
            'money'       => $this->formatMoney($transaction->money()),
            'to'          => $this->formatWallet($transaction->to()),
            'from'        => $this->formatWallet($transaction->from()),
        ];
    }

    private function formatWallet(Wallet $wallet)
    {
        return [
            'id'    => $wallet->id()->value(),
            'name'  => $wallet->name(),
            'money' => $this->formatMoney($wallet->money()),
            'ours'  => $wallet->isOurs(),
        ];
    }

    private function formatMoney(Money $money)
    {
        return [
            'currency' => (string) $money->getCurrency(),
            'amount'   => $money->getAmount() / 100,
        ];
    }
}
