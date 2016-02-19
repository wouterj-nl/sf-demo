<?php

namespace App\Bundle\Transaction;

use App\Finance\Transaction\TransactionRepository;
use App\Finance\Transaction\Transaction;
use App\Finance\Wallet\WalletId;
use Doctrine\ORM\EntityManager;

/**
 * @author Wouter J <wouter@wouterj.nl>
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

        $this->entityManager->flush($transaction);
    }

    function forWallet(WalletId $wallet)
    {
        return $this->entityManager
            ->createQuery('SELECT t FROM '.Transaction::class.' t WHERE t.from = :wallet OR t.to = :wallet')
            ->setParameter('wallet', $wallet->value())
            ->getResult();
    }
}
