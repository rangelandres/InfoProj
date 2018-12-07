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

$problemnotes = $data['problemnotes'];
$filename = $data['filename'];

// set up variables to handle errors
// is complete will be false if we find any problems when checking on the data
$isComplete = true;

// error message we'll send back to angular if we run into any problems
$errorMessage = "";



//
// Validation
//





// if we got this far and $isComplete is true it means we should add the post to the database
if ($isComplete) {
    // create a hashed version of the name    
    // we will set up the insert statement to add this new record to the database
    $insertquery = "INSERT INTO problemset(filename,problemnotes,courseid) VALUES ('$filename', '$problemnotes',1210)";
    

    
    
    // run the insert statement
    queryDB($insertquery, $db);
     
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