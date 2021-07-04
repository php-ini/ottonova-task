<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Entity;


class Employee
{

    private $fullName;
    private $dob;
    private $contractStartDate;
    private $specialContractDays;

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @return mixed
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param mixed $dob
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
    }

    /**
     * @return mixed
     */
    public function getContractStartDate()
    {
        return $this->contractStartDate;
    }

    /**
     * @param mixed $contractStartDate
     */
    public function setContractStartDate($contractStartDate)
    {
        $this->contractStartDate = $contractStartDate;
    }

    /**
     * @return mixed
     */
    public function getSpecialContractDays()
    {
        return $this->specialContractDays;
    }

    /**
     * @param mixed $specialContractDays
     */
    public function setSpecialContractDays($specialContractDays)
    {
        $this->specialContractDays = $specialContractDays;
    }

}