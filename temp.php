<?php

require __DIR__ . '/vendor/autoload.php';

use VacationCalculator\Ottivo\Service\VacationDaysCalculatorService;
use VacationCalculator\Ottivo\Repository\EmployeeRepository;
echo '<pre>';
$employeesList = (new EmployeeRepository())->getAll();
//dd($employeesList);
foreach($employeesList as $employee) {
    $vacationDaysCalculatorService = new VacationDaysCalculatorService($employee, 2001);
    $days = $vacationDaysCalculatorService->calculateTotalVacationDays();
    echo $days . '<br>';
}


echo '<h2>Just for development output purpose</h2>';
exit;