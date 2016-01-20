<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityManager;
use AppBundle\Finance\BankAccount as BankAccountEntity;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class BankAccount
{
    /** @var EntityManager */
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function fetchOrCreate($iban, $holder = null)
    {
        $account = $this->manager->find(BankAccountEntity::class, $iban);
        if (null === $account) {
            $account = BankAccountEntity::fromIban($iban, $holder);

            $this->manager->persist($account);
        }

        return $account;
    }
}
