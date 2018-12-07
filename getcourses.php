<?php
//COMMENTED
// We need to include these two files in order to work with the database
include_once('config.php');
include_once('dbutils.php');

// get a connection to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

$tablename = "course";

// set up a query to get information on courses
$query = "SELECT * FROM $tablename";

// run the query to get info on courses
$result = queryDB($query, $db);

// assign results to an array we can then send back to whomever called
$courses = array();
$i = 0;

// go through the results one by one
while ($currStudent = nextTuple($result)) {
    $courses[$i] = $currStudent;
    $courseid = $courses[$i]['courseid'];
    $coursename =  $courses[$i]['coursename'];

    
    $i++;
}

// put together a JSON object to send back the data on the courses
$response = array();
$response['status'] = 'success';

// 'value' corresponds to response.data.value in data.cstutors.controller.js
// 'courses' corresponds to ng-repeat="student in data.courses | filter:query" in the index.html file
$response['value']['courses'] = $courses;
header('Content-Type: application/json');
echo(json_encode($response));

?>