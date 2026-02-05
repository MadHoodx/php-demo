<?php

require __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('demo');
$log->pushHandler(new StreamHandler(__DIR__ . '/app.log', Logger::WARNING));

$log->warning('Application started');

echo "Hello from vulnerable PHP demo app\n";
