<?php

namespace App\Finance\Transaction\Import;

use App\Finance\Transaction\Util\CsvParser;
use Money\Currency;
use Money\Money;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class RabobankCsvImporter implements Importer
{
    public function parseTransactions($source)
    {
        $data = CsvParser::parse(
            $source,
            ['bankaccount', 'currency', null, 'credit_debit', 'amount', 'other_bankaccount', 'other_bankaccount_holder', 'booking_date', 'booking_code', null, 'desc1', 'desc2', 'desc3', 'desc4', 'desc5', 'desc6']
        );

        $transactions = [];
        foreach ($data as $transactionData) {
            $transactions[] = $transaction = ImportedTransaction::import(
                new Money(intval($transactionData['amount'] * 100), new Currency($transactionData['currency'])),
                trim(implode("\n", array_slice($transactionData, -6))),
                \DateTime::createFromFormat('Ymd', $transactionData['booking_date']),
                $transactionData + ['_source' => 'rabobank']
            );
        }

        return $transactions;
    }
}
