<?php
declare(strict_types=1);

namespace VacationCalculator\Ottivo\Output;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VacationCalculator\Ottivo\Repository\EmployeeRepository;
use VacationCalculator\Ottivo\Service\VacationDaysCalculatorService;
use VacationCalculator\Ottivo\Handler\EmployeeVacationDays\DefaultEmployeeVacationDays;

/**
 * Class VacationDaysCalculatorCommand
 * @package VacationCalculator\Ottivo\Output
 */
class VacationDaysCalculatorCommand extends Command
{
    const YEAR_ARGUMENT_INPUT = 'year';
    const COMMAND_NAME = 'vacationdays:calc';
    const COMMAND_DESCRIPTION = 'Calculate the employee vacation days based on the given year';
    const COMMAND_ARGUMENT_DESCRIPTION = 'What is the year of your interest?';
    const OUTPUT_HINT_TEXT = '<comment>The minimum vacation days: %s days</comment>';
    const OUTPUT_FIRST_LINE_TEXT = '<info>Employees vacation days based on the year %s:</info>';
    const OUTPUT_ERROR_TEXT = '<error>No employees vacation days list available %s:</error>';
    const OUTPUT_INVALID_PARAM_TEXT = '<error>Wrong input argument (year) %s:</error>';
    const OUTPUT_HEADER = ['Name', 'Vacation Days', 'Date of Birth', 'Contract start date', 'Special contract start date'];

    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription(self::COMMAND_DESCRIPTION)
            ->addArgument(self::YEAR_ARGUMENT_INPUT, InputArgument::REQUIRED, self::COMMAND_ARGUMENT_DESCRIPTION);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $yearInput = (int)$input->getArgument(self::YEAR_ARGUMENT_INPUT);

        if (empty($yearInput)) {
            $output->writeln(sprintf(self::OUTPUT_INVALID_PARAM_TEXT, $yearInput));
            return 0;
        }

        $employeesRepository = new EmployeeRepository();
        $employeesList = $employeesRepository->getAll();

        if (!empty($employeesList)) {
            $this->renderEmployeesDaysAsTableOutput($employeesList, $yearInput, $output);
        } else {
            $output->writeln(sprintf(self::OUTPUT_ERROR_TEXT, $yearInput));
        }

        return 0;
    }

    /**
     * @param array $employeesList
     * @param int $yearInput
     * @param OutputInterface $output
     */
    private function renderEmployeesDaysAsTableOutput(array $employeesList, int $yearInput, OutputInterface $output): void
    {
        $output->writeln(sprintf(self::OUTPUT_FIRST_LINE_TEXT, $yearInput));
        $output->writeln(sprintf(self::OUTPUT_HINT_TEXT, DefaultEmployeeVacationDays::MIN_CONTRACT_VACATION_DAYS));

        $employeesDaysArray = $this->getEmployeesVacationDays($employeesList, $yearInput);

        $table = new Table($output);
        $table->setStyle('box-double');
        $table
            ->setHeaders(self::OUTPUT_HEADER)
            ->setRows($employeesDaysArray);
        $table->render();
    }

    /**
     * @param array $employeesList
     * @param int $yearInput
     * @return array
     */
    public function getEmployeesVacationDays(array $employeesList, int $yearInput): array
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