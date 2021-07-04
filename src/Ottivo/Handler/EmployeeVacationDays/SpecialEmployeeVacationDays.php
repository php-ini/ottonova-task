<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Handler\EmployeeVacationDays;


use VacationCalculator\Ottivo\Entity\Employee;

class SpecialEmployeeVacationDays implements EmployeeVacationDaysHandlerInterface
{
    public function getVacationDays(Employee $employee, int $year): int
    {
        return $employee->getSpecialContractDays();
    }
}