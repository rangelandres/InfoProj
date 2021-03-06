<?php

// We need to include these two files in order to work with the database
include_once('config.php');
include_once('dbutils.php');

// get a connection to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

$tablename = "scourselist";

// set up a query to get information on students
$query = "SELECT * FROM $tablename WHERE courseid = 1110;";

// run the query to get info on students
$result = queryDB($query, $db);

// assign results to an array we can then send back to whomever called
$students = array();
$i = 0;

// go through the results one by one
while ($currStudent = nextTuple($result)) {
    $students[$i] = $currStudent;
    $hawkid = $students[$i]['hawkid'];
    
    $i++;
}

// put together a JSON object to send back the data on the students
$response = array();
$response['status'] = 'success';

// 'value' corresponds to response.data.value in data.cstutors.controller.js
// 'students' corresponds to ng-repeat="student in data.students | filter:query" in the index.html file
$response['value']['students'] = $students;
header('Content-Type: application/json');
echo(json_encode($response));

?>