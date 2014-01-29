<?php
include_once 'db_connect.php';
include_once 'functions.php';

if (isset($_POST['fromdate'])) {
	
    header("Content-type: text/xml");
 	$usereventsxml=getEvents( $mysqli);
    echo $usereventsxml;
	
} else {
			echo 'invalid request';
}
?>