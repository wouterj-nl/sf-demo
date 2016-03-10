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
use App\Finance\Transaction\Command\BookTransaction;
use App\Finance\Transaction\Import\ImportedTransaction;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
class TransactionController extends Controller
{
    /**
     * @Route("/transactions", name="book_transaction")
     * @Method("POST")
     */
    public function book(Request $request)
    {
        // See WalletController::create() for more information
        $command = new BookTransaction(
            $id = Uuid::uuid4(),
            Money::EUR(intval($request->request->get('amount') * 100)),
            $request->request->get('from'),
            $request->request->get('to'),
            new \DateTime($request->request->get('date')),
            $request->request->get('description')
        );

        try {
            $this->get('command_bus')->handle($command);
        } catch (InvalidCommandException $e) {
            // See WalletController::create() for more information
            return new JsonResponse([
                'errors' => (new FlattenViolationList($e->violations()))->toArray(),
            ], 400);
        }

        return new JsonResponse(['transaction_id' => $id], JsonResponse::HTTP_CREATED);
    }
}
