<?php
include_once 'globalconf.php';
function sec_session(){
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
	}
	
	
	}


function login($email, $password, $mysqli) {
	sec_session();
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT id, name, pass, salt 
        FROM Users
       WHERE mail = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 	
        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();
 		
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
 
            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
				
                return 'Account is locked';
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $password) {
					
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
				
					
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                 //   $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                 //                                               "", 
                 //                                               $username);
                    $_SESSION['username'] = $username;
					$_SESSION['mail'] =$email;
                    $_SESSION['login_string'] = hash('sha512', 
                              $password . $user_browser);
                 	setPrefVariables($mysqli,$user_id);
                    return 'loginOK';
					
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return 'password incorrect';
                }
            }
        } else {
            // No user exists.
            return 'no user exists';
        }
    }
}
function setPrefVariables($mysqli,$user_id){
	
	if ($stmt = $mysqli->prepare("SELECT * 
				FROM  `preferences` WHERE `user_id` =?
        LIMIT 1")) {
        $stmt->bind_param('s', $user_id);  
        $stmt->execute();   
        $stmt->store_result();
 		
        // get variables from result.
        $stmt->bind_result($user_id, $backgrcol, $backimage, $anima);
		$stmt->fetch();
		 $_SESSION['backgroundcolor']=$backgrcol;
		
		 $_SESSION['backgroundimage']=$backimage;
		
		 $_SESSION['animations']=$anima;
		
		}
	}
function savePrefVariables($mysqli){
	
	if ($stmt = $mysqli->prepare("UPDATE  `calendar`.`preferences` SET  
	`backgroundcolor` =  '?',
 	`backgroundimage` =  '?',
 	`animations` =  '?'
	
	 WHERE  `preferences`.`user_id` =?")) {
        $stmt->bind_param('ssss',$_SESSION['backgroundcolor'],$_SESSION['backgroundimage'], $_SESSION['animations'], $_SESSION['user_id']);  
        if($stmt->execute()){
			
			return true;
			} 
			return false;  
		}
	
	
	}
function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts <code><pre>
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check() {
	
	sec_session();
    if (isset($_SESSION['username'],$_SESSION['mail'],$_SESSION['login_string'])){
		return true;
		}else{
		return false;
			}
}
function logout(){
	session_start(); 
	session_destroy();
	
	
	}
function getEvents($mysqli/* ,$fromdate*/){
	
	sec_session();
	
	 $fromdate='1990-01-01';
	 $stmt = $mysqli->prepare("SELECT * 
			FROM  `Events` 
			WHERE host =  ?
			
			LIMIT 0 , 8") ;
        $stmt->bind_param('s', $_SESSION['mail']);  // Bind mail to parameter.
        $stmt->execute();    // Execute the prepared query.

		$stmt->store_result();
	
		if ($stmt->num_rows > 0) {
			$result='';
				$result='<?xml version="1.0" encoding="iso-8859-2"?>';
				
				$result.='<DATA>';
				
				
				$stmt->bind_result($event_id,$col2, $evdate,$eventGuest, $evimage ,$evname,$evdescription,$evlocation );
	
            for ($x=0; $x<$stmt->num_rows; $x++)
  				{
					$stmt->fetch();
				$result.= '<EVENT>';
				
				
				 $result.='<EVID>'.$event_id.'</EVID>';
				 
 				 $result.='<EVGUEST>'.$eventGuest.'</EVGUEST>';
				 
				 $result.='<IMAGESRC>'.$evimage.'</IMAGESRC>';
				 
				 $result.='<EVNAME>'.$evname.'</EVNAME>';
				 
				 $result.='<DSCRPT>'.$evdescription.'</DSCRPT>';
				 
				  $result.='<DATE>'.$evdate.'</DATE>';
				  
				  $result.='<LOCATION>'.$evlocation.'</LOCATION>';
				 
  				$result.= '</EVENT>';
				
				
				
				
 				 }
				 $result.='</DATA>';
				 return $result;

         
       
		
		}else{
			return 'no events';
			}
	}
function newEvent($mysqli,$eventname, $eventdate, $eventguest, $location, $eventdescription){
	
	if(login_check()){
		
		$stmt = $mysqli->prepare("INSERT INTO  `calendar`.`Events` (
				`host` ,
				`date` ,
				`eventGuest` ,
				`name` ,
				`description` ,
				`location`
				)
				VALUES (
				?, 
				?, 
			  	?,
				?, 
				?, 
				?);") ;
        $stmt->bind_param('ssssss', $_SESSION['mail'],$eventdate,$eventguest, $eventname,$eventdescription, $location); 
        $stmt->execute();    // Execute the prepared query.
		return true;
		}
	}
function removeEvent($mysqli,$eventID){

	sec_session();
	if(login_check()){
		$eventID=intval($eventID);
		$stmt = $mysqli->prepare("DELETE FROM `calendar`.`Events` WHERE `events`.`ev_id` = ?");
      	$stmt->bind_param('i', $eventID);
      	$stmt->execute();
		
							
		return true;
	
							
		}return false;
		
	}
?>