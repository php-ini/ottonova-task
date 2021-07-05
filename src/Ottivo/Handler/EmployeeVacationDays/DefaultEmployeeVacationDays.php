<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Handler\EmployeeVacationDays;


use VacationCalculator\Ottivo\Entity\Employee;

/**
 * Class DefaultEmployeeVacationDays
 * @package VacationCalculator\Ottivo\Handler\EmployeeVacationDays
 */
class DefaultEmployeeVacationDays implements EmployeeVacationDaysHandlerInterface
{
    const MIN_CONTRACT_VACATION_DAYS = 26;

    /**
     * @param Employee $employee
     * @param int $year
     * @return int
     */
    public function getVacationDays(Employee $employee, int $year): int
    {
        return self::MIN_CONTRACT_VACATION_DAYS;
    }
}