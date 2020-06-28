<?php

use PHPUnit\Framework\TestCase;

class SalaryTest extends TestCase
{
    public function testBobSalaryCalculation()
    {
        $salaryService = $this->prepareCommonDataForTesting();

        $employee = new Employee();
        $employee->setName('Bob');
        $employee->setAge(52);
        $employee->setAmountOfChildren(0);
        $employee->setSalary(4000);
        $employee->setUseCompanyCar(true);

        $salaryService->setEmployee($employee);

        $salary = $salaryService->calculateSalary();

        $this->assertEquals(2980.0, $salary);
    }

    public function testCharlieSalaryCalculation()
    {
        $salaryService = $this->prepareCommonDataForTesting();

        $employee = new Employee();
        $employee->setName('Charlie');
        $employee->setAge(36);
        $employee->setAmountOfChildren(3);
        $employee->setSalary(5000);
        $employee->setUseCompanyCar(true);

        $salaryService->setEmployee($employee);

        $salary = $salaryService->calculateSalary();

        $this->assertEquals(3600.0, $salary);
    }

    public function testAliceSalaryCalculation()
    {
        $salaryService = $this->prepareCommonDataForTesting();

        $employee = new Employee();
        $employee->setName('Alice');
        $employee->setAge(26);
        $employee->setAmountOfChildren(2);
        $employee->setSalary(6000);
        $employee->setUseCompanyCar(false);

        $salaryService->setEmployee($employee);

        $salary = $salaryService->calculateSalary();

        $this->assertEquals(4800.0, $salary);
    }

    /**
     * @return SalaryCalculationService
     */
    private function prepareCommonDataForTesting()
    {
        // Set default tax for country
        $currentCountryTax = new Tax();
        $currentCountryTax->setAmount(20);

        $salaryService = new SalaryCalculationService();
        $salaryService->setTax($currentCountryTax);

        // Prepare rules for salaries
        $rules = $this->getPreparedRules($salaryService);
        $salaryService->setCalculationRules($rules);

        return $salaryService;
    }

    /**
     * @param $salaryService
     * @return SalaryCalculationRulesService
     */
    private function getPreparedRules($salaryService)
    {
        $ageRule = $this->createAgeRule($salaryService);
        $childrenRule = $this->createAmountChildrenRule($salaryService);
        $companyCarRule = $this->companyCarRule($salaryService);

        $calculationRuleService = new SalaryCalculationRulesService();

        $calculationRuleService->addRules([
            $ageRule,
            $childrenRule,
            $companyCarRule
        ]);

        return $calculationRuleService;
    }

    /**
     * @param SalaryCalculationService $salaryService
     * @return SalaryCalculationRule
     */
    private function companyCarRule(SalaryCalculationService $salaryService)
    {
        $calculationRule = new SalaryCalculationRule();
        $calculationRule->setSubject(EmployeeInterface::EMPLOYEE_USE_COMPANY_CAR)
            ->setConditionType(SalaryCalculationRule::EQ)
            ->setConditionValue(true)
            ->setResult(
                function () use($salaryService)
                {
                    return $salaryService->deductFromSalary(500);
                }
            );

        return $calculationRule;
    }

    /**
     * @param SalaryCalculationService $salaryService
     * @return SalaryCalculationRule
     */
    private function createAmountChildrenRule(SalaryCalculationService $salaryService)
    {
        $calculationRule = new SalaryCalculationRule();

        $calculationRule
            ->setSubject(EmployeeInterface::EMPLOYEE_AMOUNT_OF_CHILDEN)
            ->setConditionType(SalaryCalculationRule::GT)
            ->setConditionValue(2)
            ->setResult(
                function () use($salaryService)
                {
                    return $salaryService->decreaseTaxPercent(2);
                }
            );

        return $calculationRule;
    }

    /**
     * @param SalaryCalculationService $salaryService
     * @return SalaryCalculationRule
     */
    private function createAgeRule(SalaryCalculationService $salaryService)
    {
        $calculationRule = new SalaryCalculationRule();

        $calculationRule
            ->setSubject(EmployeeInterface::EMPLOYEE_AGE)
            ->setConditionType(SalaryCalculationRule::GT)
            ->setConditionValue(50)
            ->setResult(
                function() use ($salaryService){
                    return $salaryService->addToSalaryPercent(7);
                }
            );

        return $calculationRule;
    }
}