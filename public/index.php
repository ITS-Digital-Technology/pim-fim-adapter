<?php

use Dotenv\Dotenv;
use NortheasternWeb\PIMFIMAdapter\FIM\FIMAdapter;
use NortheasternWeb\PIMFIMAdapter\PIM\PIMAdapter;

require_once realpath('./vendor/autoload.php');
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// $FIMAdapter = new FIMAdapter($FIMConfig, null);

$PIMAdapter = new PIMAdapter();

$programs = $PIMAdapter->getAllPrograms();
$programsByLocationSeattle = $PIMAdapter->getAllPrograms();

print('All Programs');
var_dump(json_encode($programs));