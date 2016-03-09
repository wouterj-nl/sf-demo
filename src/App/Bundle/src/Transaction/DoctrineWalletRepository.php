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

use App\Finance\Wallet\WalletRepository;
use App\Finance\Wallet\Wallet;
use App\Finance\Wallet\WalletId;
use Doctrine\ORM\EntityManager;

/**
 * A Doctrine ORM implementation for the WalletRepository.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
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
        // @todo this is really bad, you should never flush
        //       the complete system. However, I need to find
        //       a way to only flush wallets...
        $this->entityManager->flush();
    }
}
