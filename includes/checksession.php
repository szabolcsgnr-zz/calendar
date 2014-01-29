<?php
include_once 'db_connect.php';
include_once 'functions.php';

sec_session();
if (login_check()){ 

echo 'bejelentkezve';

}else{
	echo 'hiba';
	}
?>