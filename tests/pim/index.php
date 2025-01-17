<?php

namespace Northeastern\PIMFIMAdapter\Tests\PIM;

use Dotenv\Dotenv;
use Contentful\Delivery\Query;
use Northeastern\PIMFIMAdapter\PIM\PIMAdapter;
use Northeastern\PIMFIMAdapter\PIM\Model\Program;

require_once realpath('../../vendor/autoload.php');
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

echo "<h1>PIM Test</h1>";

$PIMAdapter = new PIMAdapter();

//$locationName = "Boston";
//$programId = "9n7xc2cMJK045iyZe3ELf";

// $programs = $PIMAdapter->getAllPrograms();
// $programsByLocationToronto = $PIMAdapter->getProgramsByLocationName('toronto');


// $programsByMajor = $PIMAdapter->getProgramsByMajorName('Speech-Language Pathology');

// $collegeQuery = (new Query())->select(['fields.name', 'sys.id', 'sys.updatedAt']);
// $colleges = $PIMAdapter->getCollegeList($collegeQuery);

// 1. getAllPrograms
$allPrograms = $PIMAdapter->getAllPrograms();
//$json_pretty = json_encode($allPrograms, JSON_PRETTY_PRINT);
echo stripslashes($allPrograms);


// 2. getProgramById
//$programId = "5oZiCP3mTuyPSr4XH5W83B";
//$programById = $PIMAdapter->getProgramById($programId); 
//$json_pretty = json_encode($programById, JSON_PRETTY_PRINT); 
//echo "<pre>" . $json_pretty . "<pre/>"; 

// // 3. getProgramByName
 //$programName = "Master of Science in Robotics";
 //$programByName = $PIMAdapter->getProgramByName($programName);
 //$json_pretty = json_encode($programByName, JSON_PRETTY_PRINT); 
//echo "<pre>" . $json_pretty . "<pre/>"; 

// // 4. getProgramsByCollege
// $collegeName = "Bouvé College of Health Sciences";
// $programsByCollege = $PIMAdapter->getProgramsByCollege($collegeName, (new Query)->orderBy('fields.name'));

// // 5. getProgramsByLocation
// $locationName = "Boston";
// $programsByLocation = $PIMAdapter->getProgramsByLocationName($locationName, (new Query)->orderBy('fields.name'));

// // 6. getProgramsByMajorName
// $majorName = "Test";
// $programsByMajor = $PIMAdapter->getProgramsByMajorName($majorName, (new Query)->orderBy('fields.name'));

// // 7. getProgramsByDegreeType
// $degreeType = "Test";
// $programsByDegreeType = $PIMAdapter->getProgramsByDegreeType($degreeType, (new Query)->orderBy('fields.name'));

// // 8. getProgramsByUndergradDegreeType
// $undergradDegreeType = "Bachelor's";
// $programsByUndergradDegreeType = $PIMAdapter->getProgramsByUndergradDegreeType($undergradDegreeType, (new Query)->orderBy('fields.name'));

// // 9. getProgramsByCustom
// $customQuery = (new Query)->where('fields.format', 'Online');
// $programsByCustom = $PIMAdapter->getProgramsByCustom($customQuery);

// echo "********************************************** \n";
// echo "1. Get All Programs \n";
// echo "********************************************** \n\n";
// var_dump(json_encode($allPrograms, JSON_PRETTY_PRINT));
// echo "\n";

//echo "********************************************** \n";
//echo "2. Get Program By ID: {$programId} \n";
//echo "********************************************** \n\n";
//var_dump(json_encode($programById, JSON_PRETTY_PRINT));
//echo "\n";



// echo "********************************************** \n";
// echo "3. Get Program By Name: {$programName} \n";
// echo "********************************************** \n\n";
// var_dump(json_encode($programByName, JSON_PRETTY_PRINT));
// echo "\n";

// echo "********************************************** \n";
// echo "4. Get Programs By College: {$collegeName} \n";
// echo "********************************************** \n\n";
// var_dump(json_encode($programsByCollege, JSON_PRETTY_PRINT));
// echo "\n";

// echo "********************************************** \n";
// echo "5. Get Programs By Location: {$locationName} \n";
// echo "********************************************** \n\n";
// var_dump(json_encode($programsByLocation, JSON_PRETTY_PRINT));
// echo "\n";

// echo "********************************************** \n";
// echo "6. Get Programs By Major: {$majorName} \n";
// echo "********************************************** \n\n";
// var_dump(json_encode($programsByMajor, JSON_PRETTY_PRINT));
// echo "\n";

// echo "********************************************** \n";
// echo "7. Get Programs By Degree Type: {$degreeType} \n";
// echo "********************************************** \n\n";
// var_dump(json_encode($programsByDegreeType, JSON_PRETTY_PRINT));
// echo "\n";

// echo "********************************************** \n";
// echo "8. Get Programs By Undergraduate Degree Type: {$undergradDegreeType} \n";
// echo "********************************************** \n\n";
// var_dump(json_encode($programsByUndergradDegreeType, JSON_PRETTY_PRINT));
// echo "\n";

// echo "********************************************** \n";
// echo "9. Get Programs By Custom Query: where('fields.format', 'Online') \n";
// echo "********************************************** \n\n";
// var_dump(json_encode($programsByCustom, JSON_PRETTY_PRINT));
// echo "\n";