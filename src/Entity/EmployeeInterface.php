<?php

interface EmployeeInterface
{
    const EMPLOYEE_NAME = 'name';
    const EMPLOYEE_AGE = 'age';
    const EMPLOYEE_AMOUNT_OF_CHILDEN = 'amountOfChildren';
    const EMPLOYEE_USE_COMPANY_CAR = 'useCompanyCar';

    /**
     * @return string
     */
    public function getName();
    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return int
     */
    public function getAge();

    /**
     * @param int $age
     */
    public function setAge($age);

    /**
     * @return int
     */
    public function getAmountOfChildren();

    /**
     * @param int $amountOfChildren
     */
    public function setAmountOfChildren($amountOfChildren);

    /**
     * @return bool mixed
     */
    public function getUseCompanyCar();

    /**
     * @param bool $useCompanyCar
     */
    public function setUseCompanyCar($useCompanyCar);

    public function getSalary();

    public function setSalary($salary);

    public function getOriginalSalary();

    public function setOriginalSalary($salary);

    public function getValueByType($type);
}