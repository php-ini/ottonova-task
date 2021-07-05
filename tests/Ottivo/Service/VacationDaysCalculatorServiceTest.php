<?php
declare(strict_types=1);

namespace VacationCalculator\Tests\Ottivo\Entity;

use PHPUnit\Framework\TestCase;
use VacationCalculator\Ottivo\Entity\Employee;
use VacationCalculator\Ottivo\Handler\EmployeeVacationDays\DefaultEmployeeVacationDays;
use VacationCalculator\Ottivo\Handler\EmployeeVacationDays\SpecialEmployeeVacationDays;
use VacationCalculator\Ottivo\Service\VacationDaysCalculatorService;

/**
 * Class VacationDaysCalculatorServiceTest
 * @package VacationCalculator\Tests\Ottivo\Entity
 */
class VacationDaysCalculatorServiceTest extends TestCase
{

    /**
     * @var Employee
     */
    private ?Employee $employeeEntity;

    public function setUp(): void
    {
        $this->employeeEntity = new Employee();
    }

    public function tearDown(): void
    {
        $this->employeeEntity = null;
        parent::tearDown();
    }

    public function testMinimumNormalContractDays()
    {
        $name = 'Hanz Zimmer';
        $dob = '2001-05-05';
        $startDate = '2020-01-01';
        $specialContractDays = null;
        $this->employeeEntity->setFullName($name);
        $this->employeeEntity->setDob($dob);
        $this->employeeEntity->setContractStartDate($startDate);
        $this->employeeEntity->setSpecialContractDays($specialContractDays);
        $vacationDaysService = new VacationDaysCalculatorService($this->employeeEntity, 2021);
        $this->assertEquals(DefaultEmployeeVacationDays::MIN_CONTRACT_VACATION_DAYS, $vacationDaysService->calculateTotalVacationDays());
    }

    public function testSpecialContractOverridingMinimumVacationDays()
    {
        $name = 'Hanz Zimmer';
        $dob = '1990-05-05';
        $startDate = '2020-01-01';
        $specialContractDays = 27;
        $this->employeeEntity->setFullName($name);
        $this->employeeEntity->setDob($dob);
        $this->employeeEntity->setContractStartDate($startDate);
        $this->employeeEntity->setSpecialContractDays($specialContractDays);
        $vacationDaysService = new VacationDaysCalculatorService($this->employeeEntity, 2021);
        $this->assertEquals(27, $vacationDaysService->calculateTotalVacationDays());
    }

    public function testOldEmployeeSpecialContractOverridingMinimumVacationDays()
    {
        $name = 'Hanz Zimmer';
        $dob = '1985-05-05';
        $startDate = '2020-01-01';
        $specialContractDays = 27;
        $this->employeeEntity->setFullName($name);
        $this->employeeEntity->setDob($dob);
        $this->employeeEntity->setContractStartDate($startDate);
        $this->employeeEntity->setSpecialContractDays($specialContractDays);
        $vacationDaysService = new VacationDaysCalculatorService($this->employeeEntity, 2021);
        $expected = (27 + 1); // 27 is the new special vacation days + 1 day for having age of (35)
        $this->assertEquals($expected, $vacationDaysService->calculateTotalVacationDays());
    }

    public function testOldEmployeeWithBonusVacationDays()
    {
        $name = 'Hanz Zimmer';
        $dob = '1955-05-05';
        $startDate = '2020-01-01';
        $specialContractDays = null;
        $this->employeeEntity->setFullName($name);
        $this->employeeEntity->setDob($dob);
        $this->employeeEntity->setContractStartDate($startDate);
        $this->employeeEntity->setSpecialContractDays($specialContractDays);
        $vacationDaysService = new VacationDaysCalculatorService($this->employeeEntity, 2021);
        $this->assertEquals(33, $vacationDaysService->calculateTotalVacationDays());
    }

    public function testContractsStartsMiddleMonthVacationDays()
    {
        $name = 'Hanz Zimmer';
        $dob = '1985-05-05';
        $startDate = '2020-01-15';
        $specialContractDays = null;
        $this->employeeEntity->setFullName($name);
        $this->employeeEntity->setDob($dob);
        $this->employeeEntity->setContractStartDate($startDate);
        $this->employeeEntity->setSpecialContractDays($specialContractDays);
        $vacationDaysService = new VacationDaysCalculatorService($this->employeeEntity, 2021);
        $this->assertEquals(25, $vacationDaysService->calculateTotalVacationDays());
    }

    public function testFunctionGetBonusVacationDays()
    {
        $name = 'Hanz Zimmer';
        $dob = '1980-05-05';
        $startDate = '2020-01-15';
        $specialContractDays = null;
        $this->employeeEntity->setFullName($name);
        $this->employeeEntity->setDob($dob);
        $this->employeeEntity->setContractStartDate($startDate);
        $this->employeeEntity->setSpecialContractDays($specialContractDays);
        $vacationDaysService = new VacationDaysCalculatorService($this->employeeEntity, 2021);
        $this->assertEquals(2, $vacationDaysService->getBonusVacationDays());
    }

    public function testFunctionGetVacationDaysHandlerWithDefault()
    {
        $name = 'Hanz Zimmer';
        $dob = '2001-05-05';
        $startDate = '2020-01-15';
        $specialContractDays = null;
        $this->employeeEntity->setFullName($name);
        $this->employeeEntity->setDob($dob);
        $this->employeeEntity->setContractStartDate($startDate);
        $this->employeeEntity->setSpecialContractDays($specialContractDays);
        $vacationDaysService = new VacationDaysCalculatorService($this->employeeEntity, 2021);
        $this->assertInstanceOf(DefaultEmployeeVacationDays::class, $vacationDaysService->getVacationDaysHandler() );
    }

    public function testFunctionGetVacationDaysHandlerWithWithSpecialContract()
    {
        $name = 'Hanz Zimmer';
        $dob = '2001-05-05';
        $startDate = '2020-01-15';
        $specialContractDays = 28;
        $this->employeeEntity->setFullName($name);
        $this->employeeEntity->setDob($dob);
        $this->employeeEntity->setContractStartDate($startDate);
        $this->employeeEntity->setSpecialContractDays($specialContractDays);
        $vacationDaysService = new VacationDaysCalculatorService($this->employeeEntity, 2021);
        $this->assertInstanceOf(SpecialEmployeeVacationDays::class, $vacationDaysService->getVacationDaysHandler() );
    }

}