<?php

// We need to include these two files in order to work with the database
include_once('config.php');
include_once('dbutils.php');

// get a connection to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);


    if (isset($_SESSION['hawkid'])) {
        // if the session variable hawkid is set, then we are logged in
        $hawkid = $_SESSION['hawkid'];
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