<?php

use Contentful\Core\Resource\ResourceInterface;
use Contentful\Delivery\Query;
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
var_dump(json_encode($programs, JSON_PRETTY_PRINT));
// $programsByLocationToronto = $PIMAdapter->getProgramsByLocationName('toronto');
// $programsByLocationBoston = $PIMAdapter->getProgramsByLocationName('boston');

// $programsByMajor = $PIMAdapter->getProgramsByMajorName('Speech-Language Pathology');

$collegeQuery = (new Query())->select(['fields.name', 'sys.id', 'sys.updatedAt']);
$colleges = $PIMAdapter->getCollegeList($collegeQuery);

$bouveCollege = $PIMAdapter->getProgramsByCollege("College of Engineering");
// var_dump(json_encode($bouveCollege, JSON_PRETTY_PRINT));
