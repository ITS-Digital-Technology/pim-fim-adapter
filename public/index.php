<?php

use Contentful\Core\Resource\ResourceInterface;
use Contentful\Delivery\Resource\Entry;
use Dotenv\Dotenv;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use NortheasternWeb\PIMFIMAdapter\FIM\FIMAdapter;
use NortheasternWeb\PIMFIMAdapter\PIM\PIMAdapter;

require_once realpath('./vendor/autoload.php');
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// $FIMAdapter = new FIMAdapter($FIMConfig, null);

$PIMAdapter = new PIMAdapter();

$programs = $PIMAdapter->getAllPrograms();
$programsByLocationToronto = $PIMAdapter->getProgramsByLocationName('toronto');
$programsByLocationBoston = $PIMAdapter->getProgramsByLocationName('boston');

$programsByMajor = $PIMAdapter->getProgramsByMajorName('Speech-Language Pathology');

$entries = [];

foreach ($programsByMajor as $entry) {
    $entries[] = $entry->all();
}

// var_dump(json_encode($programsByLocationToronto, JSON_PRETTY_PRINT));

// var_dump(json_encode($programsByLocationToronto, JSON_PRETTY_PRINT));

var_dump(json_encode($entries, JSON_PRETTY_PRINT));
