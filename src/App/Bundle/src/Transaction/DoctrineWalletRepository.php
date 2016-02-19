<?php

namespace App\Bundle\Transaction;

use App\Finance\Wallet\WalletRepository;
use App\Finance\Wallet\Wallet;
use App\Finance\Wallet\WalletId;
use Doctrine\ORM\EntityManager;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class DoctrineWalletRepository implements WalletRepository
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist(Wallet $wallet)
    {
        $this->entityManager->persist($wallet);
        $this->entityManager->flush($wallet);
    }

    public function oneById(WalletId $id)
    {
        $result = $this->entityManager->find(Wallet::class, $id->value());

        if (!$result) {
            throw new \LogicException(sprintf('No wallet found for ID "%s".', $id->value()));
        }

        return $result;
    }

    public function all()
    {
        return $this->entityManager->createQuery('SELECT w FROM '.Wallet::class.' w')->getResult();
    }

    public function flush()
    {
        $this->entityManager->flush();
    }
}
