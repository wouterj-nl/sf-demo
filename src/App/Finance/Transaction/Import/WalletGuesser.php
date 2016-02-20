<?php

namespace App\Finance\Transaction\Import;

use App\Finance\Wallet\WalletId;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class WalletGuesser
{
    public function guessFromWallet(ImportedTransaction $transaction)
    {
        $data = $transaction->extra();

        if ('rabobank' !== $data['_source']) {
            return;
        }

        $guesses = [];
        if ('C' === $data['credit_debit']) {
            if ('NL32INGB0663766370' === $data['other_bankaccount']) {
                $guesses[] = new WalletGuess(new WalletId('86c0a068-b3f7-434f-a602-07b79a24e10f', 100));
            }

            if ('DUO' === $data['other_bankaccount_holder']) {
                $guesses[] = new WalletGuess(new WalletId('a4586218-beac-429d-bda2-4855ce1d62c8'), 100);
            }
        }

        return $guesses;
    }

    public function guessToWallet(ImportedTransaction $transaction)
    {
        $data = $transaction->extra();

        if ('rabobank' !== $data['_source']) {
            return;
        }

        $guesses = [];
        if ('D' === $data['credit_debit']) {
            if (false !== strpos(strtoupper($data['desc1']), 'ALBERT HEIJN')) {
                $guesses[] = new WalletGuess(new WalletId('e654d947-20a5-4ac7-9030-e3c637fd2b21'), 80);
            }

            if (false !== strpos($data['desc1'], '5096 TU/E VERTIGO')) {
                $guesses[] = new WalletGuess(new WalletId('e654d947-20a5-4ac7-9030-e3c637fd2b21'), 100);
            }

            if ('NL52ABNA0893621242' === $data['other_bankaccount']) {
                $guesses[] = new WalletGuess(new WalletId('69009dbc-ebf0-4a6f-aba6-432af1455d14'), 100);
            }

            if (false !== strpos($data['desc1'], 'Werkplts')) {
                $guesses[] = new WalletGuess(new WalletId('78073eaa-43fc-47ca-84a9-d6995a3bdf80'), 90);
            }

            if (false !== strpos($data['other_bankaccount_holder'], 'Vodafone-Libertel')) {
                $guesses[] = new WalletGuess(new WalletId('39886a8a-1680-413e-a56a-786e16ffcf31'), 100);
            }

            if (false !== strpos($data['other_bankaccount_holder'], 'NS')) {
                $guesses[] = new WalletGuess(new WalletId('10cfa7da-d7c9-4229-b7cd-6633fbe95c42'), 100);
            }
        }

        return $guesses;
    }
}
