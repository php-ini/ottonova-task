<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Service;

use VacationCalculator\Ottivo\Entity\Employee;
use VacationCalculator\Ottivo\Handler\EmployeeVacationDays\DefaultEmployeeVacationDays;
use VacationCalculator\Ottivo\Handler\EmployeeVacationDays\SpecialEmployeeVacationDays;
use VacationCalculator\Ottivo\Handler\EmployeeVacationDays\EmployeeVacationDaysHandlerInterface;

class VacationDaysCalculatorService
{
    private $employee;
    private $year;
    private $vacationDaysHandler;
    private $remainingContractMonths;

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

        return round($baseVacationDays * ($this->remainingContractMonths / 12));
    }

    private function getVacationDaysHandler(): EmployeeVacationDaysHandlerInterface
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

        if ($startContractDate < $startDate) {
            return 1;
        }

        if ($startContractDate > $endDate) {
            return 0;
        }

        $difference = $endDate->diff($startContractDate);

        if ($difference->m === 0) {
            return 12;
        }

        return $difference->m;
    }
}