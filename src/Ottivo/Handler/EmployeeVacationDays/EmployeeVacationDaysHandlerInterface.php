<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Handler\EmployeeVacationDays;

use VacationCalculator\Ottivo\Entity\Employee;

interface EmployeeVacationDaysHandlerInterface
{
    public function getVacationDays(Employee $employee, int $year): int;
}