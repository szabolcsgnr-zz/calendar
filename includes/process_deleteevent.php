<?php
/**
 * These are the database login details
 */  
include_once 'db_connect.php';
include_once 'functions.php';
sec_session();


if ( isset($_POST['eventID']) &&is_numeric($_POST['eventID'])) {
	
	
    $eventID=filter_var($_POST['eventID'], FILTER_SANITIZE_NUMBER_INT);
	
 	$delEventResponse=removeEvent($mysqli,$eventID);
    if ($delEventResponse) {
        //remove success
       echo 'ok';
		exit();
    } else {
       
       echo "something went wrong removing event data";
    }
} else {
    echo 'invalid request';
}

?>