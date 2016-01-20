<?php

namespace AppBundle\Finance;

use AppBundle\Repository\BankAccount as BankAccountRepository;
use AppBundle\Util\Csv;
use Money\Currency;
use Money\Money;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class RaboCsvReader implements Reader
{
    /** @var BankAccountRepository */
    private $accountRepository;

    public function __construct(BankAccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function retrieveTransactions($source)
    {
        $data = Csv::parse(
            $source,
            ['bankaccount', 'currency', 'interest_date', 'ex_in', 'amount', 'other_bankaccount', 'other_bankaccount_holder', 'booking_date', 'booking_code', null, 'desc1', 'desc2', 'desc3', 'desc4', 'desc5', 'desc6']
        );
        $transactions = [];

        foreach ($data as $transactionData) {
            $description = trim(implode("\n", array_slice($transactionData, -6)));

            $account = $this->accountRepository->fetchOrCreate($transactionData['bankaccount']);
            $otherAccount = $transactionData['other_bankaccount']
                ? $this->accountRepository->fetchOrCreate(
                    $transactionData['other_bankaccount'], $transactionData['other_bankaccount_holder']
                  )
                : null;
            if ('D' === $transactionData['ex_in']) {
                $fromAccount = $account;
                $toAccount = $otherAccount;
            } else {
                $fromAccount = $otherAccount;
                $toAccount = $account;
            }

            $transactions[] = (new Transaction($description))
                ->amount(new Money(intval($transactionData['amount'] * 100), new Currency($transactionData['currency'])))
                ->from($fromAccount)
                ->to($toAccount)
                ->at(\DateTime::createFromFormat('Ymd', $transactionData['booking_date']))
                ->using(TransactionType::fromCode($transactionData['booking_code']))
            ;
        }

        return $transactions;
    }
}
