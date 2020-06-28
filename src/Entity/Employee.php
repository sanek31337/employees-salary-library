<?php

class Employee implements EmployeeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $age;

    /**
     * @var int
     */
    private $amountOfChildren = 0;

    /**
     * @var bool
     */
    private $useCompanyCar = false;

    /**
     * @var double
     */
    private $salary;

    /**
     * @var double
     */
    private $originalSalary;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getAmountOfChildren()
    {
        return $this->amountOfChildren;
    }

    /**
     * @param int $amountOfChildren
     */
    public function setAmountOfChildren($amountOfChildren)
    {
        $this->amountOfChildren = $amountOfChildren;
    }

    /**
     * @return bool mixed
     */
    public function getUseCompanyCar()
    {
        return $this->useCompanyCar;
    }

    /**
     * @param bool $useCompanyCar
     */
    public function setUseCompanyCar($useCompanyCar)
    {
        $this->useCompanyCar = $useCompanyCar;
    }

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param mixed $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function setOriginalSalary($salary)
    {
        $this->originalSalary = $salary;
    }

    /**
     * @return mixed
     */
    public function getOriginalSalary()
    {
        return $this->originalSalary;
    }

    public function getValueByType($type)
    {
        switch ($type)
        {
            case self::EMPLOYEE_NAME:
                return $this->getName();
                break;
            case self::EMPLOYEE_AGE:
                return $this->getAge();
                break;
            case self::EMPLOYEE_AMOUNT_OF_CHILDEN:
                return $this->getAmountOfChildren();
                break;
            case self::EMPLOYEE_USE_COMPANY_CAR:
                return $this->getUseCompanyCar();
                break;
            default:
                return null;
                break;
        }
    }
}