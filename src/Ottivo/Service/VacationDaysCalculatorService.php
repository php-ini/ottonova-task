<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Service;

use VacationCalculator\Ottivo\Entity\Employee;

class VacationDaysCalculatorService
{
    private $employee;
    private $year;

    /**
     * VacationDaysCalculatorService constructor.
     * @param Employee $employee
     * @param int $year
     */
    public function __construct(Employee $employee, int $year)
    {
        $this->employee = $employee;
        $this->year = $year;
    }

    public function calculateDays()
    {

    }
}