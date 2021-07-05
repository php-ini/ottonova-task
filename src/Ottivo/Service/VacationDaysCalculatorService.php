<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Service;

use VacationCalculator\Ottivo\Entity\Employee;
use VacationCalculator\Ottivo\Handler\EmployeeVacationDays\OldEmployeeVacationDays;
use VacationCalculator\Ottivo\Handler\EmployeeVacationDays\DefaultEmployeeVacationDays;
use VacationCalculator\Ottivo\Handler\EmployeeVacationDays\SpecialEmployeeVacationDays;
use VacationCalculator\Ottivo\Handler\EmployeeVacationDays\EmployeeVacationDaysHandlerInterface;

class VacationDaysCalculatorService
{
    private Employee $employee;
    private int $year;
    private EmployeeVacationDaysHandlerInterface $vacationDaysHandler;
    private int $remainingContractMonths;

    /**
     * VacationDaysCalculatorService constructor.
     * @param Employee $employee
     * @param int $year
     */
    public function __construct(Employee $employee, int $year)
    {
        $this->employee = $employee;
        $this->year = $year;
        $this->vacationDaysHandler = $this->getVacationDaysHandler();
        $this->remainingContractMonths = $this->getRemainingContractMonths();
    }

    public function calculateTotalVacationDays()
    {
        $baseVacationDays = $this->vacationDaysHandler->getVacationDays($this->employee, $this->year);
        $bonusVacationDays = $this->employee->getEmployeeAgeInYears($this->year) >= OldEmployeeVacationDays::THRESHOLD_AGE_FOR_BONUS ? $this->getBonusVacationDays() : 0;

        return round($baseVacationDays * ($this->remainingContractMonths / 12)) + $bonusVacationDays;
    }

    public function getBonusVacationDays(): int
    {
        return (new OldEmployeeVacationDays())->getVacationDays($this->employee, $this->year);
    }

    public function getVacationDaysHandler(): EmployeeVacationDaysHandlerInterface
    {
        if (!is_null($this->employee->getSpecialContractDays())) {
            return new SpecialEmployeeVacationDays();
        }

        return new DefaultEmployeeVacationDays();
    }

    private function getRemainingContractMonths(): int
    {
        $startContractDate = new \DateTime($this->employee->getContractStartDate());
        $startDate = new \DateTime($this->year . '-01-01');
        $endDate = new \DateTime($this->year + 1 . '-01-01');
        $difference = $endDate->diff($startContractDate);

        if ($startContractDate > $endDate) {
            return 0;
        }

        if ($difference->m === 0) {
            return 12;
        }

        return $difference->m;
    }
}