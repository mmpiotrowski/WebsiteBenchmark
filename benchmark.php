<?php

require __DIR__ . '/config/bootstrap.php';

use WebsiteBenchmark\Benchmark;

$benchmark = new Benchmark($config, $argv, $argc);
$benchmark->run();

?>