<?php
/**
 * These are the database login details
 */  
include_once 'db_connect.php';
include_once 'functions.php';
sec_session();
 
 	$saveresponse=savePrefVariables($mysqli);
    if ($saveresponse) {
  
       echo 'ok';
	
		exit();
    } else {
      
      echo 'error';
    }


?>