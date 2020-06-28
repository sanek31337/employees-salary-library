<?php

interface TaxInterface
{
    public function getAmount();

    public function setAmount($amount);

    public function getAmountPercent();
}