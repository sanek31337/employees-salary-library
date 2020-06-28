<?php

interface SalaryCalculationRuleInterface
{
    public function addRule(SalaryCalculationRule $calculationRule);
    public function addRules($calculationRules);
    public function getRules();
}