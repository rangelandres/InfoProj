<?php
    
    // We need to include these two files in order to work with the database
    include_once('config.php');
    include_once('dbutils.php');
    
    // log in user by checking whether the session variable hawkid is set
    session_start();
    if (isset($_SESSION['hawkid'])) {
        // if the session variable hawkid is set, then we are logged in
        $isloggedin = true;
        $hawkid = $_SESSION['hawkid'];
    } else {
        // if we are not logged in
        $isloggedin = false;
        $hawkid = "not logged in";        
    }
    
    // get a connection to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    $tablename = "fcourselist";
    
    // set up a query to get information on students
    $query = "SELECT courseid FROM $tablename WHERE hawkid = '$hawkid';";

    // run the query to get info on students
    $result = queryDB($query, $db);

    
    $courses = array();
    $i = 0;
    
    // go through the results one by one
    while ($currCourse = nextTuple($result)) {
        $courses[$i] = $currCourse;
        $courseid = $courses[$i]['courseid'];

        
        $i++;
    }
    
    $c1210 = false;
    $c1020 = false;
    $c1110 = false;
    
 
    
    foreach ($courses as $value) {
        if (in_array("1210", $value)){
            $c1210 = true;
        }
        if (in_array("1020", $value)){
            $c1020 = true;
        }
        if (in_array("1110", $value)){
            $c1110 = true;
        }
    }
        
    
    // send response back
    $response = array();
    $response['status'] = 'success';
    $response['loggedin'] = $isloggedin;
    $response['hawkid'] = $hawkid;
    $response['value']['courses'] = $courses;
    $response['c1210'] = $c1210;
    $response['c1020'] = $c1020;
    $response['c1110'] = $c1110;

    header('Content-Type: application/json');
    echo(json_encode($response));
    
    
?>