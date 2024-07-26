<?php

namespace NortheasternWeb\PIMFIMAdapter\Tests\PIM;

use Contentful\Delivery\Query;
use Dotenv\Dotenv;
use NortheasternWeb\PIMFIMAdapter\PIM\PIMAdapter;
use NortheasternWeb\PIMFIMAdapter\PIM\Model\Program;

require_once realpath('./vendor/autoload.php');
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

echo "--- PIM Test ---\n";

$PIMAdapter = new PIMAdapter();
$collegeName = "Bouvé College of Health Sciences";
$locationName = "Boston";

// $programs = $PIMAdapter->getAllPrograms();
// $programsByLocationToronto = $PIMAdapter->getProgramsByLocationName('toronto');
$programsByLocationBoston = $PIMAdapter->getProgramsByLocationName($locationName);

// $programsByMajor = $PIMAdapter->getProgramsByMajorName('Speech-Language Pathology');

$collegeQuery = (new Query())->select(['fields.name', 'sys.id', 'sys.updatedAt']);
$colleges = $PIMAdapter->getCollegeList($collegeQuery);

$bouveCollege = $PIMAdapter->getProgramsByCollege($collegeName, (new Query)->orderBy('fields.name'));

$programByCollegeCollection = collect($bouveCollege)->map(function($item) {
    return (new Program($item))->toArray();
});

echo "-- Get Programs By College: 'Bouvé College of Health Sciences' --\n";
var_dump(json_encode($programByCollegeCollection, JSON_PRETTY_PRINT));

