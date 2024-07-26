<?php

use Dotenv\Dotenv;
use NortheasternWeb\PIMFIMAdapter\ContentfulAdapter;
use NortheasternWeb\PIMFIMAdapter\FIM\FIMAdapter;

require_once realpath('./vendor/autoload.php');
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