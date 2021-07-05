<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Handler\EmployeeVacationDays;

use VacationCalculator\Ottivo\Entity\Employee;

/**
 * Interface EmployeeVacationDaysHandlerInterface
 * @package VacationCalculator\Ottivo\Handler\EmployeeVacationDays
 */
interface EmployeeVacationDaysHandlerInterface
{
    /**
     * @param Employee $employee
     * @param int $year
     * @return int
     */
    public function getVacationDays(Employee $employee, int $year): int;
}