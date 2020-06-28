<?php

class SalaryCalculationRulesService implements SalaryCalculationRuleInterface
{
    /**
     * @var array $rules
     */
    private $rules;

    public function addRule(SalaryCalculationRule $calculationRule)
    {
        $this->rules[] = $calculationRule;
    }

    /**
     * @param SalaryCalculationRule[] $calculationRules
     */
    public function addRules($calculationRules)
    {
        foreach ($calculationRules as $calculationRule)
        {
            $this->addRule($calculationRule);
        }
    }

    /**
     * @return SalaryCalculationRule[] array
     */
    public function getRules()
    {
        return $this->rules;
    }
}