<?php

use GisoStallenberg\CorrectHorseBatteryStapleAPI\CorrectHorseBatteryStapleAPI;
use Symfony\Component\Yaml\Parser;

require __DIR__ . '/../vendor/autoload.php';

$yaml = new Parser();
$configuration = $yaml->parse(file_get_contents(__DIR__ . '/../config.yml.dist'));

if (file_exists(__DIR__ . '/../config.yml') ) {
    $configuration = array_merge(
        $configuration,
        $yaml->parse(file_get_contents(__DIR__ . '/../config.yml'))
    );
}

$correctHorseBatteryStapleAPI = new CorrectHorseBatteryStapleAPI($configuration);
$correctHorseBatteryStapleAPI->run();
