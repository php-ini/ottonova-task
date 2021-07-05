<?php
declare(strict_types=1);

namespace VacationCalculator\Tests\Ottivo\Output;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use VacationCalculator\Ottivo\Output\VacationDaysCalculatorCommand;
use VacationCalculator\Ottivo\Repository\EmployeeRepository;

class VacationDaysCalculatorCommandTest extends TestCase
{
    private $applocation;
    private $command;
    private $commandTester;

    public function setUp(): void
    {
        $this->application = new Application();
        $this->application->add(new VacationDaysCalculatorCommand());

        $this->command = $this->application->find(VacationDaysCalculatorCommand::COMMAND_NAME);
        $this->commandTester = new CommandTester($this->command);
    }

    public function tearDown(): void
    {
        $this->applocation = null;
        $this->command = null;
        $this->commandTester = null;
        parent::tearDown();
    }

    public function testExecuteWithValidData()
    {
        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
            VacationDaysCalculatorCommand::YEAR_ARGUMENT_INPUT => '2021'
        ));

        $this->assertMatchesRegularExpression('/Employees vacation days based on the year/', $this->commandTester->getDisplay());
    }

    public function testExecuteWithInvalidData()
    {
        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
            VacationDaysCalculatorCommand::YEAR_ARGUMENT_INPUT => 'invalid'
        ));

        $this->assertMatchesRegularExpression('/Wrong input argument \(year\)/', $this->commandTester->getDisplay());
    }

    public function testGetEmployeesVacationDays()
    {
        $command = new VacationDaysCalculatorCommand();
        $employeesRepository = new EmployeeRepository();
        $employeesList = $employeesRepository->getAll();

        $result = $command->getEmployeesVacationDays($employeesList, 2021);
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }
}