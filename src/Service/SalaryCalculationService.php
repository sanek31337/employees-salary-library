<?php

class SalaryCalculationService implements SalaryCalculationInterface
{
    /**
     * @var TaxInterface
     */
    private $tax;

    /**
     * @var EmployeeInterface
     */
    private $employee;

    /**
     * @var SalaryCalculationRulesService
     */
    private $calculationRules;

    public function setTax(TaxInterface $tax)
    {
        $this->tax = $tax;
    }

    public function setEmployee(EmployeeInterface $employee)
    {
        $this->employee = $employee;
    }

    public function setCalculationRules(SalaryCalculationRulesService $salaryCalculationRulesService)
    {
        $this->calculationRules = $salaryCalculationRulesService;
    }

    public function addCalculationRule(SalaryCalculationRule $salaryCalculationRule)
    {
        $this->calculationRules->addRule($salaryCalculationRule);
    }

    /**
     * @param int $salaryPercent
     */
    public function addToSalaryPercent($salaryPercent)
    {
        $newSalary = $this->employee->getSalary() + ($this->employee->getOriginalSalary() * ($salaryPercent / 100));
        $this->employee->setSalary($newSalary);
    }

    /**
     * @param int $salaryPercent
     */
    public function deductFromSalaryPercent($salaryPercent)
    {
        $newSalary = $this->employee->getSalary() - ($this->employee->getOriginalSalary() * $salaryPercent);
        $this->employee->setSalary($newSalary);
    }

    /**
     * @param int $salaryAmount
     */
    public function addToSalary($salaryAmount)
    {
        $newSalary = $this->employee->getSalary() + $salaryAmount;
        $this->employee->setSalary($newSalary);
    }

    /**
     * @param int $salaryAmount
     */
    public function deductFromSalary($salaryAmount)
    {
        $newSalary = $this->employee->getSalary() - $salaryAmount;
        $this->employee->setSalary($newSalary);
    }

    public function decreaseTaxPercent($taxPercent)
    {
        $newTax = $this->tax->getAmountPercent() - $taxPercent;
        $this->tax->setAmount($newTax);
    }

    public function increaseTaxPercent($taxPercent)
    {
        $newTax =  $this->tax->getAmount() + $taxPercent;
        $this->tax->setAmount($newTax);
    }

    public function calculateSalary()
    {
        $this->employee->setOriginalSalary($this->employee->getSalary());

        $rules = $this->calculationRules->getRules();

        if (count($rules) > 0)
        {
            foreach ($rules as $rule)
            {
                $this->checkRule($this->employee, $rule);
            }
        }

        return $this->getSalaryWithTax();
    }

    private function getSalaryWithTax()
    {
        return $this->employee->getSalary() - ($this->employee->getOriginalSalary() * $this->tax->getAmount());
    }

    private function checkRule(EmployeeInterface $employee, SalaryCalculationRule $rule)
    {
        $subjectValue = $employee->getValueByType($rule->getSubject());

        $rule->checkRuleCondition($subjectValue);
    }
}