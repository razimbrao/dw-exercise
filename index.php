<?php

use Php\Dw\Connect;
use Php\Dw\Csv;

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/createDatabases.php";
require_once __DIR__ . "/tableScripts/stagingAreaConfig.php";
require_once __DIR__ . "/tableScripts/dimensions/createDimensions.php";
require_once __DIR__ . "/tableScripts/fact/sales.php";

$csv = new Csv(__DIR__ . "/TabelaAtividade.csv");

createStagingArea($csv);
createDimensions();
createFactSales();
createDailySalesFact();
