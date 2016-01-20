<?php

namespace AppBundle\Controller;

use AppBundle\Finance\RaboCsvReader;
use AppBundle\Finance\Transaction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class TransactionController extends Controller
{
    /** @Route("/transaction/sync") */
    public function sync(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('transaction_data', FileType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('transaction_data')->getData();
            $csv = file_get_contents($file->getRealPath());

            $transactions = $this->get('app.reader.rabo')->retrieveTransactions($csv);

            $manager = $this->getDoctrine()->getManager();
            foreach ($transactions as $transaction) {
                $manager->persist($transaction);
            }
            $manager->flush();

            return new Response('Success');
        }

        return $this->render('transaction/sync.twig', [
            'form' => $form->createView(),
        ]);
    }

    /** @Route("/transactions") */
    public function show()
    {
        /** @var Transaction[] $transactions */
        $transactions = $this->getDoctrine()->getRepository(Transaction::class)->findAll();
        $expenses = [];
        $income = [];
        $totalExpend = 0;
        $totalIncome = 0;
        $ownAccount = $this->getParameter('own_account');

        foreach ($transactions as $transaction) {
            if ($ownAccount === $transaction->fromAccount()->number()) {
                $expenses[] = $transaction;
                $totalExpend -= $transaction->money()->getAmount();
            } else {
                $income[] = $transaction;
                $totalIncome += $transaction->money()->getAmount();
            }
        }

        usort($transactions, function (Transaction $a, Transaction $b) {
            $diff = $a->time()->diff($b->time())->days;

            if (0 === $diff) {
                return 0;
            }

            return $diff > 0 ? 1 : -1;
        });

        return $this->render('transaction/show.twig', [
            'expenses' => $expenses,
            'income'   => $income,
            'transactions' => $transactions,
            'total_expenses' => $totalExpend,
            'total_income'   => $totalIncome,
        ]);
    }
}
