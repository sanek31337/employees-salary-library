<?php

class Tax implements TaxInterface
{
    private $amount;

    /**
     * @return mixed
     */
    public function getAmountPercent()
    {
        return $this->amount;
    }

    public function getAmount()
    {
        return $this->amount / 100;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}