<?php

require __DIR__ . '/functions.php';

use VendingMachine\Application\VendingMachine\ServiceFactory;
use VendingMachine\Infrastructure\VendingMachine\Repositories\InMemoryVendingMachineRepository;

$serviceFactory = new ServiceFactory(new InMemoryVendingMachineRepository());

$pattern = "/--actions=(.+)/";
$str = $argv[1];
preg_match($pattern, $argv[1], $matches);

$actions = $matches[1];

$actions = explode(',', $actions);
foreach ($actions as $action) {
    switch ($action) {
        case 'GET-JUICE':
        case 'GET-SODA':
        case 'GET-WATER':
            $value = (explode('-', $action))[1];
            $value = strtolower($value);

            processVendItem($serviceFactory, $value);
            break;
        case 'RETURN-COINS':
            processReturnCoins($serviceFactory);
            break;
        case '1.00':
        case '0.25':
        case '0.10':
        case '0.05':
            processInsertCoin($serviceFactory, $action);
            break;
        default:
            break;
    }
}

echo "\n";
echo "THANKS!\n";
exit;
