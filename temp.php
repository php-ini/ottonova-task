<?php
/**
 * This is a temporary php file to test the development cycle
 * @deprecated
 */

require __DIR__ . '/vendor/autoload.php';

use VacationCalculator\Ottivo\Service\VacationDaysCalculatorService;
use VacationCalculator\Ottivo\Repository\EmployeeRepository;

$employeesList = (new EmployeeRepository())->getAll();

foreach($employeesList as $employee) {
    $vacationDaysCalculatorService = new VacationDaysCalculatorService($employee, 2001);
    $days = $vacationDaysCalculatorService->calculateTotalVacationDays();
    echo $days . '<br>';
}


echo '<h2>Just for development output purpose</h2>';
exit;