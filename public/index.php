<?php

require realpath(__DIR__ . '/../vendor/autoload.php');

if (
    !empty($_GET['name']) &&
    !empty($_GET['age']) &&
    !empty($_GET['children_amount']) &&
    !empty($_GET['salary'])
)
{
    // Set default tax for country
    $currentCountryTax = new Tax();
    $currentCountryTax->setAmount(20);

    $salaryService = new SalaryCalculationService();
    $salaryService->setTax($currentCountryTax);

    // Prepare rules for salaries
    $rules = getPreparedRules($salaryService);
    $salaryService->setCalculationRules($rules);

    $employee = new Employee();
    $employee->setName($_GET['name']);
    $employee->setAge((int)$_GET['age']);
    $employee->setAmountOfChildren((int)$_GET['children_amount']);
    $employee->setSalary($_GET['salary']);
    $employee->setUseCompanyCar(!empty($_GET['use_company_car']));

    $salaryService->setEmployee($employee);

    $salary = $salaryService->calculateSalary();
}

function getPreparedRules($salaryService)
{
    $ageRule = addAgeRule($salaryService);
    $childrenRule = createAmountChildrenRule($salaryService);
    $companyCarRule = companyCarRule($salaryService);

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
function companyCarRule(SalaryCalculationService $salaryService)
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
function createAmountChildrenRule(SalaryCalculationService $salaryService)
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
function addAgeRule(SalaryCalculationService $salaryService)
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

?>

<html>

    <!doctype html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Hello, world!</title>
    </head>
    <body>

    <div class="container">
        <?php if($salary): ?>
            <div>
                <p>
                <h2>Net Salary result:</h2>
                </p>
                <p>
                    <?=$salary?>
                </p>
            </div>
        <?php endif; ?>
        <div>
            <h2>Salary Calculation form</h2>
            <form id="calculate-salary">
                <div class="form-group">
                    <label for="name">Employeer</label>
                    <input type="text" class="form-control" name="name" value="<?=$_GET['name']?>" placeholder="Enter employee name">
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="text" class="form-control" name="age" value="<?=$_GET['age']?>" placeholder="Age">
                </div>
                <div class="form-group">
                    <label for="age">How many Children?</label>
                    <input type="text" class="form-control" name="children_amount" value="<?=$_GET['children_amount']?>" placeholder="Children">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" <?=((isset($_GET['use_company_car']) && $_GET['use_company_car'] == 'on') ? "checked='checked'" : '')?> name="use_company_car">
                    <label class="form-check-label" for="use_company_car">
                        Use a company car
                    </label>
                </div>
                <div class="form-group">
                    <label for="salary">Salary</label>
                    <input type="text" class="form-control" name="salary" value="<?=$_GET['salary']?>" placeholder="Salary">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    </body>
</html>