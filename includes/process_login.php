<?php
/**
 * These are the database login details
 */  
include_once 'db_connect.php';
include_once 'functions.php';
sec_session();
 
if (isset($_POST['email'], $_POST['p'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['p']; // The hashed password.
 	$loginresponse=login($email,$password , $mysqli);
    if ($loginresponse == 'loginOK') {
        // Login success 
       echo 'ok';
		echo $_SESSION['username'];
		exit();
    } else {
        // Login failed 
       echo $loginresponse;
    }
} else {
    echo 'invalid request';
}

?>