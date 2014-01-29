<?php
/**
 * These are the database login details
 */  
include_once 'db_connect.php';
include_once 'functions.php';
sec_session();


if (isset($_POST['eventguestmail'], $_POST['eventname'],$_POST['eventdate'],$_POST['eventlocation'], $_POST['eventdescription'])) {
    $guestemail = filter_input(INPUT_POST, 'eventguestmail', FILTER_SANITIZE_EMAIL);
	
	$eventname= filter_input(INPUT_POST, 'eventname', FILTER_SANITIZE_SPECIAL_CHARS);
	$eventdate= filter_input(INPUT_POST, 'eventdate', FILTER_SANITIZE_SPECIAL_CHARS);
	$eventlocation= filter_input(INPUT_POST, 'eventlocation', FILTER_SANITIZE_SPECIAL_CHARS);
	$eventdesc= filter_input(INPUT_POST, 'eventdescription', FILTER_SANITIZE_SPECIAL_CHARS);
	
	$eventname=filter_var($eventname,FILTER_SANITIZE_SPECIAL_CHARS);
	$eventdate=filter_var($eventdate,FILTER_SANITIZE_SPECIAL_CHARS);
	$eventlocation=filter_var($eventlocation,FILTER_SANITIZE_SPECIAL_CHARS);
	$eventdesc=filter_var($eventdesc,FILTER_SANITIZE_SPECIAL_CHARS);
	
 	$newEventInsertResponse=newEvent($mysqli,$eventname, $eventdate, $guestemail, $eventlocation, $eventdesc);
    if ($newEventInsertResponse) {
        // insert success
       echo 'ok';
		exit();
    } else {
        // Login failed 
       echo "something went wrong saving event data";
    }
} else {
    echo 'invalid request';
}

?>