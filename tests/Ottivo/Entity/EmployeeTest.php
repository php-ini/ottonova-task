<?php
declare(strict_types=1);

namespace VacationCalculator\Tests\Ottivo\Entity;

use PHPUnit\Framework\TestCase;
use VacationCalculator\Ottivo\Entity\Employee;

/**
 * Class EmployeeTest
 * @package VacationCalculator\Tests\Ottivo\Entity
 */
class EmployeeTest extends TestCase
{
    /**
     * @var Employee
     */
    private $employeeEntity;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $dob;
    /**
     * @var string
     */
    private $startDate;
    /**
     * @var null
     */
    private $specialContractDays;

    public function setUp(): void
    {
        $this->employeeEntity = new Employee();
        $this->name = 'Hanz Zimmer';
        $this->dob = '1985-05-05';
        $this->startDate = '2020-01-01';
        $this->specialContractDays = null;
        $this->employeeEntity->setFullName($this->name);
        $this->employeeEntity->setDob($this->dob);
        $this->employeeEntity->setContractStartDate($this->startDate);
        $this->employeeEntity->setSpecialContractDays($this->specialContractDays);
    }

    public function tearDown(): void
    {
        $this->employeeEntity = null;
        $this->name = null;
        $this->dob = null;
        $this->startDate = null;
        parent::tearDown();
    }


    public function testEmployeeEntityGettersAndSetters()
    {
        $employee = $this->employeeEntity;
        $this->assertEquals($this->name, $employee->getFullName());
        $this->assertEquals($this->dob, $employee->getDob());
        $this->assertEquals($this->startDate, $employee->getContractStartDate());
        $this->assertEquals($this->specialContractDays, $employee->getSpecialContractDays());
    }

    public function testFunctiongetEmployeeAgeByYear()
    {
        $employee = $this->employeeEntity;
        $expected = 35; // calculating the full age years until the  start of the given year.

        $employee->setDob($this->dob);
        $this->assertEquals($expected, $employee->getEmployeeAgeInYears(2021));
    }
}