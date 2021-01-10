<?php

require __DIR__ . '/functions.php';

use VendingMachine\Application\VendingMachine\ServiceFactory;
use VendingMachine\Infrastructure\VendingMachine\Repositories\InMemoryVendingMachineRepository;

$serviceFactory = new ServiceFactory(new InMemoryVendingMachineRepository());

$endVending = true;
while ($endVending) {
    echo "Type an action (insert-coin, get, return-coins, end): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);

    switch (trim($line)) {
        case 'insert-coin':
        case 'ic':
            processInsertCoin($serviceFactory);
            break;
        case 'return-coins':
        case 'rc':
            processReturnCoins($serviceFactory);
            break;
        case 'get':
        case 'g':
            processVendItem($serviceFactory);
            break;
        case 'end':
        case 'e':
            $endVending = false;
            break;
        default:
            break;
    }

    fclose($handle);
}

echo "\n";
echo "Thank you!\n";
exit;
