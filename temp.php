<?php

require __DIR__ . '/vendor/autoload.php';

use VacationCalculator\Ottivo\Service\VacationDaysCalculatorService;

$employeesList = include(__DIR__ . '/src/Ottivo/Seeder/Employees/List.php');
dd($employeesList);
$vacationDaysCalculatorService = new VacationDaysCalculatorService();
$vacationDaysCalculatorService->calculateDays();

echo '<h2>Just for development output purpose</h2>';
exit;