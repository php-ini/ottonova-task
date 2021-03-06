<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Entity;


/**
 * Class Employee
 * @package VacationCalculator\Ottivo\Entity
 */
class Employee
{
    /**
     * @var
     */
    private $fullName;
    /**
     * @var
     */
    private $dob;
    /**
     * @var
     */
    private $contractStartDate;
    /**
     * @var
     */
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

    /**
     * @param int $year
     * @return int
     * @throws \Exception
     */
    public function getEmployeeAgeInYears(int $year): int
    {
        $birthDate = new \DateTime($this->getDob());
        $now = new \DateTime($year . '-01-01');
        $difference = $now->diff($birthDate);

        return $difference->y;
    }

}