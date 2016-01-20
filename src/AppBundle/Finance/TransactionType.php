<?php

namespace AppBundle\Finance;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class TransactionType
{
    const AC = 'acceptgiro';
    const BA = 'betaalautomaat';
    const BC = 'betalen contactloos';
    const BG = 'bankgiro opdracht';
    const CB = 'crediteurenbetaling';
    const CK = 'Chipknip';
    const DB = 'diverse boekingen';
    const EI = 'euro-incasso';
    const GA = 'geldautomaat Euro';
    const GB = 'geldautomaat VV';
    const ID = 'iDEAL';
    const KH = 'kashandeling';
    const MA = 'machtiging';
    const NB = 'NotaBox';
    const SB = 'salaris betaling';
    const SP = 'spoedopdracht';
    const TB = 'eigen rekening';
    const TG = 'telegiro';
    const CR = 'tegoed';
    const D  = 'tekort';

    private $code;
    private $name;

    private function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    public static function fromCode($code)
    {
        $code = strtoupper($code);
        $constants = (new \ReflectionClass(static::class))->getConstants();

        if (isset($constants[$code])) {
            return new static($code, $constants[$code]);
        }

        throw new \InvalidArgumentException(sprintf('Undefined transaction type code: "%s"', $code));
    }

    public function name()
    {
        return $this->name;
    }

    public function code()
    {
        return $this->code;
    }

    public function __toString()
    {
        return $this->code();
    }
}
