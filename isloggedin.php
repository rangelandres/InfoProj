<?php
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

    // send response back
    $response = array();
    $response['status'] = 'success';
    $response['loggedin'] = True; //$isloggedin, changed to true
    $response['hawkid'] = $hawkid;
    header('Content-Type: application/json');
    echo(json_encode($response));
    
    
?>