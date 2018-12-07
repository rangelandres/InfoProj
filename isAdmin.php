<?php
    
    // Start the session
    session_start();
    
    include_once('config.php');
    include_once('dbutils.php');
    

    // connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);    
    
    $hawkid = $_SESSION['hawkid'];
    
    $query = "SELECT administrator FROM account WHERE hawkid = '$hawkid';";
    $result = queryDB($query, $db);
    
    echo $result;
    
    if ($result)) {
        // if the
        $isadmin = true;     
        
    } else {
        // if we are not admin in
        $isadmin = false;
    }

    // send response back
    $response = array();
    $response['status'] = 'success';
    $response['isadmin'] = $isadmin;
    $response['hawkid'] = $hawkid;

    header('Content-Type: application/json');
    echo(json_encode($response));
    
    
?>