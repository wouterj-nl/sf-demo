<?php

namespace App\Bundle\Controller;

use App\Bundle\View\Transaction;
use App\Bundle\View\Wallet;
use App\Finance\Transaction\BankTransaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class DashboardController extends Controller
{
    /** @Route("/", name="homepage") */
    public function index()
    {
        $wallets = array_map(function ($wallet) {
            return Wallet::fromEntity(
                $wallet,
                Transaction::fromEntities(
                    $this->get('app.repository.transaction')->forWallet($wallet->id()),
                    $wallet->id()
                )
            );
        }, $this->get('app.repository.wallet')->all());

        return $this->render('dashboard/index.twig', ['wallets' => array_filter($wallets, function (Wallet $wallet) {
            return $wallet->name !== '_world';
        })]);
    }
}
