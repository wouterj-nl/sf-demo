<?php

namespace App\Finance\Transaction\Import;

use App\Finance\Wallet\WalletId;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class WalletGuess
{
    /**
     * A number indicating the confidence, the higher the
     * more confident the guesser is about the guess.
     *
     * @var int
     */
    private $confidence;
    /** @var WalletId */
    private $walletId;

    public function __construct(WalletId $walletId, $confidence = 0)
    {
        $this->walletId = $walletId;
        $this->confidence = $confidence;
    }

    public function confidence()
    {
        return $this->confidence;
    }

    public function wallet()
    {
        return $this->wallet;
    }
}
