<?php
//COMMENTED
// We need to include these two files in order to work with the database
include_once('config.php');
include_once('dbutils.php');

// get a connection to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

$tablename = "account";

// set up a query to get information on accounts
$query = "SELECT * FROM $tablename";

// run the query to get info on accounts
$result = queryDB($query, $db);

// assign results to an array we can then send back to whomever called
$accounts = array();
$i = 0;

// go through the results one by one
while ($currStudent = nextTuple($result)) {
    $accounts[$i] = $currStudent;
    $fname = $accounts[$i]['fname'];
    $lname = $accounts[$i]['lname'];
    $hawkid =  $accounts[$i]['hawkid'];
    $student = $accounts[$i]['student'];
    $tutor = $accounts[$i]['tutor'];
    $administrator = $accounts[$i]['administrator'];
    $faculty = $accounts[$i]['faculty'];
    
    $i++;
}

// put together a JSON object to send back the data on the accounts
$response = array();
$response['status'] = 'success';

// 'value' corresponds to response.data.value in data.cstutors.controller.js
// 'accounts' corresponds to ng-repeat="student in data.accounts | filter:query" in the index.html file
$response['value']['accounts'] = $accounts;
header('Content-Type: application/json');
echo(json_encode($response));

?>