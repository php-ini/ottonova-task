<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Handler\EmployeeVacationDays;


use VacationCalculator\Ottivo\Entity\Employee;

/**
 * Class SpecialEmployeeVacationDays
 * @package VacationCalculator\Ottivo\Handler\EmployeeVacationDays
 */
class SpecialEmployeeVacationDays implements EmployeeVacationDaysHandlerInterface
{
    /**
     * @param Employee $employee
     * @param int $year
     * @return int
     */
    public function getVacationDays(Employee $employee, int $year): int
    {
        return $employee->getSpecialContractDays();
    }
}