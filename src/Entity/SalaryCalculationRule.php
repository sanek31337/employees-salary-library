<?php

class SalaryCalculationRule
{
    const GT = '>';
    const GTE = '>=';
    const LT = '<';
    const LTE = '<=';
    const EQ = '==';

    /**
     * @var mixed
     */
    private $subject;

    /**
     * @var mixed
     */
    private $conditionValue;

    /**
     * @var mixed
     */
    private $conditionType;

    /**
     * @var mixed
     */
    private $result;


    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     * @return SalaryCalculationRule
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConditionValue()
    {
        return $this->conditionValue;
    }

    /**
     * @param mixed $conditionValue
     * @return SalaryCalculationRule
     */
    public function setConditionValue($conditionValue)
    {
        $this->conditionValue = $conditionValue;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConditionType()
    {
        return $this->conditionType;
    }

    /**
     * @param mixed $conditionType
     * @return SalaryCalculationRule
     */
    public function setConditionType($conditionType)
    {
        $this->conditionType = $conditionType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param Closure $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    public function checkRuleCondition($subjectValue)
    {
        $condition = false;

        switch ($this->getConditionType())
        {
            case '>':
                $condition = ($subjectValue > $this->getConditionValue());
                break;
            case '>=':
                $condition = ($subjectValue >= $this->getConditionValue());
                break;
            case '<':
                $condition = ($subjectValue < $this->getConditionValue());
                break;
            case '<=':
                $condition = ($subjectValue <= $this->getConditionValue());
                break;
            case '==':
                $condition = ($subjectValue === $this->getConditionValue());
                break;
        }

        if ($condition)
        {
            call_user_func($this->getResult());
        }
    }
}