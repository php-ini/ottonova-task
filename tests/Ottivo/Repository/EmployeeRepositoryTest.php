<?php
declare(strict_types=1);

namespace VacationCalculator\Tests\Ottivo\Repository;

use PHPUnit\Framework\TestCase;
use VacationCalculator\Ottivo\Entity\Employee;
use VacationCalculator\Ottivo\Repository\EmployeeRepository;

/**
 * Class EmployeeRepositoryTest
 * @package VacationCalculator\Tests\Ottivo\Repository
 */
class EmployeeRepositoryTest extends TestCase
{
    /**
     * @var EmployeeRepository
     */
    private ?EmployeeRepository $employeeRepository;


    public function setUp(): void
    {
        $this->employeeRepository = new EmployeeRepository();
    }

    public function tearDown(): void
    {
        $this->employeeRepository = null;
        parent::tearDown();
    }

    public function testBuild()
    {
        $employeesList = $this->employeeRepository->getAll();
        $this->assertIsArray($employeesList);
        $this->assertObjectHasAttribute('fullName', $employeesList[0]);
    }

    public function testSeederDataExists()
    {
        $file = $this->employeeRepository::EMPLOYEES_SEEDER_FILE;
        $this->assertFileExists($file);
    }

    public function testGetAll()
    {
        $result = $this->employeeRepository->getAll();
        $this->assertIsArray($result);
        $this->assertInstanceOf(Employee::class, $result[0]);
    }


}