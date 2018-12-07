<?php
//COMMENTED
// We need to include these two files in order to work with the database
include_once('config.php');
include_once('dbutils.php');


// get a handle to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

// get data from the angular controller
// decode the json object
$data = json_decode(file_get_contents('php://input'), true);


// get each piece of data

$HawkID = $data['HawkID'];
$fname = $data['fname'];
$lname = $data['lname'];
$student = $data['student'];
$tutor = $data['tutor'];
$administrator = $data['administrator'];
$faculty = $data['faculty'];
$cs1110 = $data['cs1110'];
$cs1210 = $data['cs1210'];
$cs2110 = $data['cs2110'];


// set up variables to handle errors
// is complete will be false if we find any problems when checking on the data
$isComplete = true;

// error message we'll send back to angular if we run into any problems
$errorMessage = "";

//
// Validation
//

// check if HawkID meets criteria
if (!isset($HawkID) || (strlen($HawkID) < 2)) {
    $isComplete = false;
    $errorMessage .= "Please enter a HawkID with at least two characters. ";
} else {
    $HawkID = makeStringSafe($db, $HawkID);
}


// check if we already have a HawkID that matches the one the user entered
if ($isComplete) {
    // set up a query to check if this HawkID is in the database already
    $query = "SELECT hawkid FROM account WHERE HawkID='$HawkID'";
    
    // we need to run the query
    $result = queryDB($query, $db);
    
    // check on the number of records returned
    if (nTuples($result) > 0) {
        // if we get at least one record back it means the HawkID is taken
        $isComplete = false;
        $errorMessage .= "The HawkID $HawkID is already taken. Please select a different HawkID. ";
    }
}



//inserts into scourselist if account is student
if($student){
    if($cs1110){$insertcs1110 = "INSERT INTO scourselist(hawkid, courseid, budget, currbudget) VALUES ('$HawkID', 'CS:1110', 4, 4)";queryDB($insertcs1110, $db);}
    if($cs1210){$insertcs1210 = "INSERT INTO scourselist(hawkid, courseid, budget, currbudget) VALUES ('$HawkID', 'CS:1210', 4, 4)";queryDB($insertcs1210, $db);}
    if($cs2110){$insertcs2110 = "INSERT INTO scourselist(hawkid, courseid, budget, currbudget) VALUES ('$HawkID', 'CS:2110', 4, 4)";queryDB($insertcs2110, $db);}
}

//inserts into tcourselist if account is tutor
if($tutor){
    if($cs1110){$insertcs1110t = "INSERT INTO tcourselist(hawkid, courseid, budget, currbudget) VALUES ('$HawkID', 'CS:1110', 20, 20)";queryDB($insertcs1110t, $db);}
    if($cs1210){$insertcs1210t = "INSERT INTO tcourselist(hawkid, courseid, budget, currbudget) VALUES ('$HawkID', 'CS;1210', 20, 20)";queryDB($insertcs1210t, $db);}
    if($cs2110){$insertcs2110t = "INSERT INTO tcourselist(hawkid, courseid, budget, currbudget) VALUES ('$HawkID', 'CS:2110', 20, 20)";queryDB($insertcs2110t, $db);}
}

//inserts into fcourselist if account is faculty
if($faculty){
    if($cs1110){$insertcs1110f = "INSERT INTO fcourselist(hawkid, courseid) VALUES ('$HawkID', 'CS:1210')";queryDB($insertcs1110f, $db);}
    if($cs1210){$insertcs1210f = "INSERT INTO fcourselist(hawkid, courseid) VALUES ('$HawkID', 'CS:1110')";queryDB($insertcs1210f, $db);}
    if($cs2110){$insertcs2110f = "INSERT INTO fcourselist(hawkid, courseid) VALUES ('$HawkID', 'CS:2110')";queryDB($insertcs2110f, $db);}
}







// if we got this far and $isComplete is true it means we should add the account to the database
if ($isComplete) {
    // create a hashed version of the name    
    // we will set up the insert statement to add this new record to the database
    $insertquery = "INSERT INTO account(hawkid, fname, lname, hashedpass,student,tutor,administrator,faculty) VALUES ('$HawkID', '$fname','$lname', '$HawkID', '$student', '$tutor','$administrator', '$faculty')";
    

    
    
    // run the insert statement
    queryDB($insertquery, $db);
    
    // get the id of the account we just entered
    $accountid = mysqli_insert_id($db);
    


    
    // send a response back to angular
    $response = array();
    $response['status'] = 'success';
    $response['id'] = $accountid;
    header('Content-Type: application/json');
    echo(json_encode($response));    
} else {
    // there's been an error. We need to report it to the angular controller.
    
    // one of the things we want to send back is the data that his php file received
    ob_start();
    var_dump($data);
    $postdump = ob_get_clean();
    
    // set up our response array
    $response = array();
    $response['status'] = 'error';
    $response['message'] = $errorMessage . $postdump;
    header('Content-Type: application/json');
    echo(json_encode($response));    
}

?>