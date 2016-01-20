<?php

namespace AppBundle\Twig;

use AppBundle\Finance\Transaction;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class AppExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'app';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('strip_payment_info', function ($description) {
                return preg_replace('/^Betaalautomaat.+$/m', '', $description);
            }),
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('to_google_data', function ($transactions) {
                $data     = [];
                $expenses = 0;
                $income   = 0;
                $money    = 0;

                usort($transactions, function (Transaction $a, Transaction $b) {
                    if ($a->time()->format('Ymd') === $b->time()->format('Ymd')) {
                        return 0;
                    }

                    return $a->time() > $b->time() ? -1 : 1;
                });

                /** @var Transaction $transaction */
                foreach ($transactions as $transaction) {
                    $amount = $transaction->money()->getAmount() / 100;
                    if ($transaction->isIncome()) {
                        $income += $amount;
                        $money  += $amount;
                    } else {
                        $expenses -= $amount;
                        $money    -= $amount;
                    }

                    $time = $transaction->time()->format('Y-m-d');
                    $data[$time] = [$money, $expenses, $income];
                    dump($data[$time]);
                }

                $json = '';
                foreach ($data as $time => $moneyAtTheTime) {
                    list($year, $month, $day) = explode('-', $time, 3);
                    $json .= sprintf(
                        '[new Date(%s, %s, %s), %s, %s, %s],',
                        $year, intval($month) - 1, $day,
                        $moneyAtTheTime[0],
                        $moneyAtTheTime[1],
                        $moneyAtTheTime[2]
                    );
                }

                return '['.rtrim($json, ',').']';
            })
        ];
    }
}
