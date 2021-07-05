<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Output;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VacationCalculator\Ottivo\Handler\EmployeeVacationDays\DefaultEmployeeVacationDays;
use VacationCalculator\Ottivo\Service\VacationDaysCalculatorService;
use VacationCalculator\Ottivo\Repository\EmployeeRepository;

class VacationDaysCalculatorCommand extends Command
{
    const YEAR_ARGUMENT_INPUT = 'year';

    protected function configure()
    {
        $this->setName("vacationdays:calc")
            ->setDescription("Calculate the employee vacation days based on the given year")
            ->addArgument(self::YEAR_ARGUMENT_INPUT, InputArgument::REQUIRED, 'What is the year of your interest?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $yearInput = (int)$input->getArgument(self::YEAR_ARGUMENT_INPUT);
        $employeesRepository = new EmployeeRepository();
        $employeesList = $employeesRepository->getAll();

        if (!empty($employeesList)) {
            $this->renderEmployeesDaysAsTableOutput($employeesList, $yearInput, $output);
        } else {
            $output->writeln('<error>No employees vacation days list available ' . $yearInput . ':</error>');
        }

        return 0;
    }

    private function renderEmployeesDaysAsTableOutput(array $employeesList, int $yearInput, OutputInterface $output): void
    {
        $output->writeln('<info>Employees vacation days based on the year ' . $yearInput . ':</info>');
        $output->writeln('<comment>The minimum vacation days: ' . DefaultEmployeeVacationDays::MIN_CONTRACT_VACATION_DAYS . ' days</comment>');

        $employeesDaysArray = $this->getEmployeesVacationDays($employeesList, $yearInput);

        $table = new Table($output);
        $table->setStyle('box-double');
        $table
            ->setHeaders(['Name', 'Vacation Days', 'Date of Birth', 'Contract start date', 'Special contract start date'])
            ->setRows($employeesDaysArray);
        $table->render();
    }

    private function getEmployeesVacationDays(array $employeesList, int $yearInput): array
    {
        $employeesDaysArray = [];

        foreach ($employeesList as $key => $employeeInfo) {
            $vacationDaysCalculatorService = new VacationDaysCalculatorService($employeeInfo, $yearInput);
            $days = $vacationDaysCalculatorService->calculateTotalVacationDays();

            /* @var \VacationCalculator\Ottivo\Entity\Employee $employeeInfo */
            $employeesDaysArray[$key][] = $employeeInfo->getFullName();
            $employeesDaysArray[$key][] = $days;
            $employeesDaysArray[$key][] = $employeeInfo->getDob();
            $employeesDaysArray[$key][] = $employeeInfo->getContractStartDate();
            $employeesDaysArray[$key][] = !is_null($employeeInfo->getSpecialContractDays()) ? $employeeInfo->getSpecialContractDays() : '-';
        }

        return $employeesDaysArray;
    }
}