<?php

use Contentful\Core\Resource\ResourceInterface;
use Contentful\Delivery\Query;
use Contentful\Delivery\Resource\Entry;
use Dotenv\Dotenv;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use NortheasternWeb\PIMFIMAdapter\FIM\FIMAdapter;
use NortheasternWeb\PIMFIMAdapter\PIM\PIMAdapter;
use NortheasternWeb\PIMFIMAdapter\PIM\Model\Program;

require_once realpath('../vendor/autoload.php');
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

echo "<h1>FIM Test</h1>";

$FIMAdapter = new FIMAdapter();

echo "<h2>getAllProfiles Method</h2>";

$profiles = $FIMAdapter->getAllProfiles();

$json_pretty = json_encode($profiles, JSON_PRETTY_PRINT); 
echo "<pre>" . $json_pretty . "<pre/>";


echo "<h2>getProfileById Method (Using '6TYr2iS5mVIFeL7UE88y6Q')</h2>";

$profilebyid = $FIMAdapter->getProfileById('6TYr2iS5mVIFeL7UE88y6Q');

$json_pretty = json_encode($profilebyid, JSON_PRETTY_PRINT); 
echo "<pre>" . $json_pretty . "<pre/>"; 


echo "<h2>getProfileByName Method (Using 'Kenneth Williams')</h2>";

$profilebyname = $FIMAdapter->getProfileByName('Kenneth Williams');

$json_pretty = json_encode($profilebyname, JSON_PRETTY_PRINT); 
echo "<pre>" . $json_pretty . "<pre/>"; 


echo "<h1>PIM Test</h1>";

$PIMAdapter = new PIMAdapter();

// $programs = $PIMAdapter->getAllPrograms();
// $programsByLocationToronto = $PIMAdapter->getProgramsByLocationName('toronto');
$programsByLocationBoston = $PIMAdapter->getProgramsByLocationName('boston');

// $programsByMajor = $PIMAdapter->getProgramsByMajorName('Speech-Language Pathology');

$collegeQuery = (new Query())->select(['fields.name', 'sys.id', 'sys.updatedAt']);
$colleges = $PIMAdapter->getCollegeList($collegeQuery);

$bouveCollege = $PIMAdapter->getProgramsByCollege("Bouvé College of Health Sciences", (new Query)->orderBy('fields.name'));

$programCollection = collect($programsByLocationBoston)->map(function($item) {
    return (new Program($item))->toArray();
});

var_dump(json_encode($programCollection, JSON_PRETTY_PRINT));