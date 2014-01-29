function formhash() {
	
    var p ;
 
 
    p= hex_sha512(document.getElementById("password").value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
 	signInAjax(document.getElementById("email").value, p);
  
}
  
 
 
function regformhash(form, uid, email, password, conf) {
     // Check each field has a value
    if (uid.value == ''         || 
          email.value == ''     || 
          password.value == ''  || 
          conf.value == '') {
 
        document.getElementById("errorField").innerHTML="You must provide all the requested details. Please try again";
        return false;
    }
 
 if (uid.value.length < 6) {
        document.getElementById("errorField").innerHTML="Name must be az least 6 characcters!";
        form.password.focus();
        return false;
    }
 
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        document.getElementById("errorField").innerHTML="Passwords must be at least 6 characters long.  Please try again";
        form.password.focus();
        return false;
    }
 
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        document.getElementById("errorField").innerHTML="Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again";
        return false;
    }
 
    // Check password and confirmation are the same
    if (password.value != conf.value) {
       document.getElementById("errorField").innerHTML="Your password and confirmation do not match. Please try again";
        form.password.focus();
        return false;
    }
 
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";
 
    // Finally submit the form. 
    signUpAjax(email.value,uid.value, p.value);
    return true;
}
    function signUpAjax(mail, usr, p){
		
		xmlhttp=null;
		if (window.XMLHttpRequest)
  		{// code for IE7+, Firefox, Chrome, Opera, Safari
  				xmlhttp=new XMLHttpRequest();
  		}
		else
  		{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 		 }
		xmlhttp.onreadystatechange=function()
  		{
  			if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
   			document.getElementById("errorField").innerHTML=xmlhttp.responseText;
			
    		}
  		}	
	
		
		var parameters="username="+encodeURIComponent(usr)+"&email="+mail+"&p="+p;
		xmlhttp.open("POST","includes/register.inc.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(parameters);
		
		
		}
function signInAjax(mail,p){
	xmlhttp=null;
		if (window.XMLHttpRequest)
  		{// code for IE7+, Firefox, Chrome, Opera, Safari
  				xmlhttp=new XMLHttpRequest();
  		}
		else
  		{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 		 }
		xmlhttp.onreadystatechange=function()
  		{
  			if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
			var singinresult=xmlhttp.responseText.substr(0,2);
			if(singinresult=='ok' ){
				// userName=xmlhttp.responseText.substr(2,xmlhttp.responseText.length-2);
				// initUserEvents('1990-01-01');
				 location.reload();
   				
			}else{
				document.getElementById("signInDiv").innerHTML=xmlhttp.responseText;
			
			}
			
			
    		}
  		}	
	
		
		var parameters="email="+mail+"&p="+p;
		xmlhttp.open("POST","includes/process_login.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(parameters);
	
	}
function logout(){
	
	xmlhttp=null;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	userName="none";
   document.getElementById("signInDiv").innerHTML="logged out";
   location.reload();
    //window.open("logoutsuccess.php")
    }
  }
xmlhttp.open("GET","includes/logout.php",true);
xmlhttp.send();
	}