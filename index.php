<?php
require __DIR__ . '/vendor/autoload.php';

if ($argv[1] === '--interactive') {
    require  __DIR__ . '/src/Infrastructure/Console/Interactive/index.php';
} else {
    require  __DIR__ . '/src/Infrastructure/Console/NonInteractive/index.php';
}
