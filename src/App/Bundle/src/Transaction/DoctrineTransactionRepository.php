<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bundle\Transaction;

use App\Finance\Transaction\TransactionRepository;
use App\Finance\Transaction\Transaction;
use App\Finance\Wallet\WalletId;
use Doctrine\ORM\EntityManager;

/**
 * A Doctrine ORM implementation for the TransactionRepository.
 *
 * Instead of using Doctrine repositories, the EntityManager is
 * injected and methods are called directly on it. We do not have
 * to use Doctrine repositories to fetch entities.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
class DoctrineTransactionRepository implements TransactionRepository
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist(Transaction $transaction)
    {
        $this->entityManager->persist($transaction);

        // *Always* call flush only for the appropriate object, otherwise
        // all changes in the current request will be flushed and this
        // service doesn't know if that's the correct thing to do or not.
        $this->entityManager->flush($transaction);
    }

    function forWallet(WalletId $wallet)
    {
        // Except when you need to build a query dynamically, it's much
        // easier to use DQL.
        return $this->entityManager
            ->createQuery('SELECT t FROM '.Transaction::class.' t WHERE t.from = :wallet OR t.to = :wallet')
            ->setParameter('wallet', $wallet->value())
            ->getResult();
    }
}
