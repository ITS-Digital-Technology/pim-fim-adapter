<?php

use Contentful\Core\Resource\ResourceInterface;
use Contentful\Delivery\Query;
use Contentful\Delivery\Resource\Entry;
use Dotenv\Dotenv;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use NortheasternWeb\PIMFIMAdapter\FIM\FIMAdapter;
use NortheasternWeb\PIMFIMAdapter\PIM\PIMAdapter;
use NortheasternWeb\PIMFIMAdapter\PIM\Model\Program;

require_once realpath('./vendor/autoload.php');
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// $FIMAdapter = new FIMAdapter($FIMConfig, null);

$PIMAdapter = new PIMAdapter();

// $programs = $PIMAdapter->getAllPrograms();
// var_dump(json_encode($programs, JSON_PRETTY_PRINT));
// $programsByLocationToronto = $PIMAdapter->getProgramsByLocationName('toronto');
// $programsByLocationBoston = $PIMAdapter->getProgramsByLocationName('boston');

// $programsByMajor = $PIMAdapter->getProgramsByMajorName('Speech-Language Pathology');

$collegeQuery = (new Query())->select(['fields.name', 'sys.id', 'sys.updatedAt']);
$colleges = $PIMAdapter->getCollegeList($collegeQuery);

$bouveCollege = $PIMAdapter->getProgramsByCollege("Bouvé College of Health Sciences");
// var_dump(json_encode($bouveCollege, JSON_PRETTY_PRINT));

$programCollection = collect($bouveCollege)->map(function($item) {
    return (new Program($item))->toArray();
});

var_dump(json_encode($programCollection, JSON_PRETTY_PRINT));