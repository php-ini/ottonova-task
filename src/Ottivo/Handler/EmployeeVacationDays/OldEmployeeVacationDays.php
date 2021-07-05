<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Handler\EmployeeVacationDays;


use VacationCalculator\Ottivo\Entity\Employee;

/**
 * Class OldEmployeeVacationDays
 * @package VacationCalculator\Ottivo\Handler\EmployeeVacationDays
 */
class OldEmployeeVacationDays implements EmployeeVacationDaysHandlerInterface
{
    const THRESHOLD_AGE_FOR_BONUS = 30;
    const THRESHOLD_YEARS_FOR_EXTRA_DAY = 5;

    /**
     * @param Employee $employee
     * @param int $year
     * @return int
     * @throws \Exception
     */
    public function getVacationDays(Employee $employee, int $year): int
    {
        $today = new \DateTime($year . '-01-01');
        $birthDate = new \DateTime($employee->getDob());

        $yearsDifference = (int)floor($today->diff($birthDate)->y);

        if ($yearsDifference < self::THRESHOLD_AGE_FOR_BONUS) {
            return 0;
        }

        return (int)floor(($yearsDifference - self::THRESHOLD_AGE_FOR_BONUS) / self::THRESHOLD_YEARS_FOR_EXTRA_DAY);
    }
}