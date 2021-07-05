<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Repository;

use VacationCalculator\Ottivo\Entity\Employee;

/**
 * Class EmployeeRepository
 * @package VacationCalculator\Ottivo\Repository
 */
class EmployeeRepository
{
    const EMPLOYEES_SEEDER_FILE = __DIR__ . '/../../Ottivo/Seeder/Employees/List.php';

    /**
     * @var array
     */
    private array $employees = [];

    /**
     * EmployeeRepository constructor.
     */
    public function __construct()
    {
        $this->build();
    }

    private function build(): void
    {
        $employees = [];
        $employeesList = include(self::EMPLOYEES_SEEDER_FILE);

        foreach ($employeesList as $employeeInfo) {
            $employee = new Employee();
            $employee->setFullName($employeeInfo['fullName']);
            $employee->setDob($employeeInfo['dob']);
            $employee->setContractStartDate($employeeInfo['contractStartDate']);
            $employee->setSpecialContractDays($employeeInfo['specialContractDays']);
            $employees[] = $employee;
        }

        $this->employees = $employees;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->employees;
    }
}