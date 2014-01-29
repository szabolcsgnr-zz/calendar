
var userName= "<?php echo $usrname ?>";   

document.getElementById("signInDiv").innerHTML="";


function profile(){
	
	if(""!=document.getElementById("signInDiv").innerHTML){
	document.getElementById("signInDiv").innerHTML="";
	return;
	}
	if (userName!="none") {
		var loggedin="Signed in: "+userName+"<br>	<input type=\"button\" id=\"logoutbutton\" onclick=\"logout()\" value=\" logout\"/>";
		
		document.getElementById("signInDiv").innerHTML=loggedin;
		return;
		}
	
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
   	document.getElementById("signInDiv").innerHTML=xmlhttp.responseText;
	document.getElementById("email").focus();
    }
  }
xmlhttp.open("GET","textcontents/login.html",true);
xmlhttp.send();
	}
	
	
function focusChangeToEnter(){
           document.getElementById("enterButton").focus();
        }
		
function signUp(){
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
	document.getElementById("signUpDiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","textcontents/signup.html",true);
xmlhttp.send();
	
	
	}		
function remSignUp(){
	document.getElementById("signUpDiv").innerHTML="";
	
	}