<?php

require __DIR__.'/vendor/autoload.php';

use VacationCalculator\Ottivo\Service\VacationDaysCalculatorService;

$vacationDaysCalculatorService = new VacationDaysCalculatorService();
$vacationDaysCalculatorService->calculateDays();

echo '<h2>Just for development output purpose</h2>';
exit;