<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session();
if (login_check()){
	 $usrname=$_SESSION['username'];
	
	}else{
		$usrname='none';
		$_SESSION['backgroundcolor']='white';
		}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Calendar</title>

<script src="js/forms.js" ></script>
<script src="js/sha512.js" ></script>
<script>
//declarations
var popupimgsrc="imgcontents/popUp.png";
var userName= "<?php echo $usrname ?>";   





</script>
<style>
* { margin: 0; padding: 0;}

body, html { height:100%; }

#evCanvas {
    position:absolute;
    width:100%;
    height:100%;
	background-color:<?php echo $_SESSION['backgroundcolor'] ?>;
}


.menu {
    position:absolute;
    width:160px;
    height:60px;
	bottom:20px;
	left:30%;
	z-index:2;
	//background:rgba(255,255,204,1);


}
#prefIcon{

	
	
	-webkit-transition-duration: 1s;
    -moz-transition-duration: 1s;
    -o-transition-duration: 1s;
    transition-duration: 1s;
     
    -webkit-transition-property: -webkit-transform;
    -moz-transition-property: -moz-transform;
    -o-transition-property: -o-transform;
    transition-property: transform;
     
    overflow:hidden;

	}
#prefIcon:hover{
	-webkit-transform:rotate(180deg);
    -moz-transform:rotate(180deg);
    -o-transform:rotate(180deg);
	
	}
	
#menuHelp{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: italic;
	font-weight: normal;
	color: rgba(204,204,204,1);
	text-align: center;
	text-decoration: none;
	}
#popUpBox{ 	
	
	position:absolute; 
	bottom:80px; 
	left:30%; 
	width:300;
	height:300px;	
	z-index:5;
}
#eventHolder{ 	
	
	position:absolute; 
	top:50%;
	margin-top:-250px; 
	left:70%; 
	margin-left:-150px;

	z-index:5;
	//background-color:grey;
}
#signInDiv{ 	
	
	position:absolute; 
	bottom:100px;

	left:35%; 
	
	z-index:5;
	
}
#newEventDiv{ 	
	
	position:absolute; 
	bottom:50%;

	left:50%; 
	
	margin-top:-170px; 
	left:50%; 
	margin-left:-150px;
	
	z-index:5;
	
}

.popUpBgImage{
	position:absolute;
	width:300px; 
	height:5px;
	top:0px;
	left:0px;
	z-index:-2;
	
	}
.popUpBgImageTransiton{
	position:absolute;
	width:300px; 
	height:300px;
	top:0px;
	left:0px;
	z-index:-2;
	
	transition-property: height;
	transition-duration: 0.5s;
	transition-timing-function: linear;

	/* Safari */
	-webkit-transition-property:height;
	-webkit-transition-duration:0.5s;
	-webkit-transition-timing-function:linear;

	}			
	
#newEventIcon{
	
	
	}	
#newEventIcon:hover{
	width:40px; 
	height:40px;
	
	}		
</style>
</head>

<body onload="init()">
<div id="popUpBox">

</div>

<div id="eventHolder">

</div>
<div id="signInDiv">

</div>
<div id="signUpDiv">

</div>
<div id="newEventDiv">

</div>
<div class="menu" >
<a href="#" style="text-decoration: none;">
<table onmouseout="delSugoText()">
<tr>
	<a href="#" style="text-decoration: none;">
	<td width="40px" onclick="prefBox()" onmouseover="prefSugo()" >
<img src="imgcontents/preficoncircle.png" title="Preferences" id="prefIcon"  width="40px" height="40px"  >
	</td>
    <td width="40px" onclick="" onmouseover="envSugo()">
<img src="imgcontents/envelope.png" title="Messages" id="envelopeIcon"  width="40px" height="40px"  >
	</td>
    <td  width="40px"  onmouseover="profSugo()" onclick="profile()">
    <img src="imgcontents/proficon.png" title="Profile" id="profilIcon"  width="40px" height="40px"  >
   
    </td>
     <td  width="40px"  onmouseover="newEventSugo()" onclick="newEvent()">
    <img src="imgcontents/newEvent.png" title="New event" id="newEventIcon"  width="30px" height="30px"  >
   
    </td>
    </a>
   <script>
 



document.getElementById("signInDiv").innerHTML="";


function profile(){
	
	if(""!=document.getElementById("signInDiv").innerHTML){
	document.getElementById("signInDiv").innerHTML="";
	return;
	}
	if (userName!="none") {
				loggedInDiv();	
				
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
	
function loggedInDiv(){
	
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
							
							document.getElementById("loggedinas").innerHTML="Logged in as "+userName;
							
  						  }
 					 }
				xmlhttp.open("GET","textcontents/loggedin.html",true);
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
   </script>
    
  
</tr>

<tr>
	<td id="menuHelp" colspan="3" width="100%">

	</td>
</tr>
</table>

</div>
<script>
/*
**
**New events
**
*/
var newEventOpen=0;
function newEvent(){
	if (userName=="none"){
		document.getElementById("newEventDiv").innerHTML="";
		profile();
		return;
		}
	if (newEventOpen!=0 ){
		newEventOpen=0;
		
		document.getElementById("newEventDiv").innerHTML="";
		return;
		}
	newEventOpen=1;
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
   	document.getElementById("newEventDiv").innerHTML=xmlhttp.responseText;
	
	document.getElementById("newEventImage").src=popupimgsrc;
    }
  }
xmlhttp.open("GET","textcontents/newevent.html",true);
xmlhttp.send();
	
	}
function saveEvent(){
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
   			location.reload();
			
    		}
  		}	
		var eventguestmail=encodeURIComponent(document.getElementById("eventGuestTextbox").value);
		var eventname=encodeURIComponent(document.getElementById("meetingnametxtbox").value);
		var eventdate=encodeURIComponent(document.getElementById("meetingdatebox").value);
		var eventlocation=encodeURIComponent(document.getElementById("locationTextbox").value);
 		var eventdescription=encodeURIComponent(document.getElementById("descriptiontxtbox").value);
		
		var parameters="eventguestmail="+eventguestmail+"&eventname="+eventname+"&eventdate="+eventdate+"&eventlocation="+
		eventlocation+"&eventdescription="+eventdescription;
		xmlhttp.open("POST","includes/process_newevent.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(parameters);
	
	}
</script>
<canvas id="evCanvas" onclick="popUp()" onmousedown="dragEventsScroll()" onmouseup="dragEventsScrollend()">

Your browser does not support the HTML5 canvas tag.
</canvas>


<script>

var c=document.getElementById("evCanvas");
var ctx=c.getContext("2d");
var eventID=new Array();
var eventNames=new Array();
var eventDates=new Array();
var eventGuests=new Array();
var eventLocation=new Array();
var eventDiscription=new Array();
var eventImage=new Array();

var xmlhttp;

var eltolasX=0;
var eltolasXseb=-1;
var animationOn=1;

eventDates[0]= "ma 2 kor";
eventDates[1]= "ma 3 kor";
eventDates[2]= "holnap reggel 8-kor";
eventDates[3]= "holnap reggel 10-kor";
eventDates[4]= "holnap";
eventDates[5]= "holnap után";
eventDates[6]= "január 27.";
eventDates[7]= "holnap reggel 10-kor";
eventDates[8]= "holnap";
eventDates[9]= "holnap után";
eventDates[10]= "január 27.";

var coordinatesX=new Array();
var coordinatesY=new Array();
var coordinatesZ=new Array();
var txtSize=new Array();
var mousePos;

var inFocusName;
var prevZ;
var prefOpen=0;
function init() {
 	ctx.canvas.width  = window.innerWidth;
  	ctx.canvas.height = window.innerHeight;
	
	<?php 
	if (login_check()){
			echo 'initUserEvents(\'\');';
		}else{
			echo 'initEvents();';
			
			}
	
	?>
}

function initEvents(){
	for(i=0; i<8; i++){
		eventNames[i]="eventName"+i;	
	}
	calculatePositions(eventNames);
}
	
function initUserEvents(datestring){
			eventID=new Array();
			 eventNames=new Array();
			eventDates=new Array();
			 eventGuests=new Array();
			 eventLocation=new Array();
			 eventDiscription=new Array();
			 eventImage=new Array();
			
	
	
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
			xmlDoc=xmlhttp.responseXML;
		
			 eventData=xmlDoc.getElementsByTagName("EVENT");
		
				
			 for(i=0; i<8 ;i++){
				try
       				   {
				 xx=eventData[i].getElementsByTagName("EVNAME");
				   xx=eventData[i].getElementsByTagName("EVNAME");
       				 try
       				   {
        			  eventNames[i]=xx[0].firstChild.nodeValue;
       				   }
       				 catch (er)
        			  {
        			  eventNames[i]="-";
        			  }
        			
					xx=eventData[i].getElementsByTagName("DATE");
       				 try
       				   {
        			  eventDates[i]=xx[0].firstChild.nodeValue;
       				   }
       				 catch (er)
        			  {
        			  eventDates[i]="-";
        			  }	
						
					xx=eventData[i].getElementsByTagName("EVGUEST");
       				 try
       				   {
        			  eventGuests[i]=xx[0].firstChild.nodeValue;
       				   }
       				 catch (er)
        			  {
        			  eventGuests[i]="-";
        			  }	
		
					 xx=eventData[i].getElementsByTagName("LOCATION");
       				 try
       				   {
        			  eventLocation[i]=xx[0].firstChild.nodeValue;
       				   }
       				 catch (er)
        			  {
        			  eventLocation[i]="-";
        			  }	
					  
					   xx=eventData[i].getElementsByTagName("DSCRPT");
       				 try
       				   {
        			  eventDiscription[i]=xx[0].firstChild.nodeValue;
       				   }
       				 catch (er)
        			  {
        			  eventDiscription[i]="-";
        			  }	
					  
					  
					   xx=eventData[i].getElementsByTagName("IMAGESRC");
       				 try
       				   {
        			  eventImage[i]=xx[0].firstChild.nodeValue;
       				   }
       				 catch (er)
        			  {
        			  eventImage[i]="-";
        			  }	
					  xx=eventData[i].getElementsByTagName("EVID");
       				 try
       				   {
        			  eventID[i]=xx[0].firstChild.nodeValue;
       				   }
       				 catch (er)
        			  {
        			  eventID[i]="-";
        			  }	
					  }
					  catch (err)
        			  {
						 break;
						  }
				
	
				}
				
			 calculatePositions(eventNames);
    		}
  		}	
	
		
		var parameters="fromdate=" + datestring;
		xmlhttp.open("POST","includes/getuserevents.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(parameters);
	
	
	
	}	
	
function calculatePositions(eventNames){
		for(i=0; i<eventNames.length;i++){
			eventNames[i];
			
			var x; 
			var y;

		
				x=Math.floor((Math.random()* window.innerWidth/1.5)+100);
				y=Math.floor((Math.random()* window.innerHeight/1.5)+100);
				for(elozo=0; elozo<i;elozo++){
					if(Math.abs(x-coordinatesX[elozo])<300){
						if(Math.abs(y-coordinatesY[elozo])<50){
							calculatePositions(eventNames);
							return;
							}
						
						}}
			
			
			
			coordinatesX[i]=x;
			coordinatesY[i]=y;
			coordinatesZ[i]=i+1;
			
			}
		redraw();	
			
		
}

window.setInterval("eltolasSzamitas()",70);

function eltolasSzamitas(){
		
		if (eltolasX>100){
			eltolasXseb=-1;
			}
		if (eltolasX<-100){
			eltolasXseb=+1;
			}
			eltolasX+=eltolasXseb;
			
			redraw();
			
	}
function redraw(){
	
	ctx.clearRect ( 0 , 0 ,  window.innerWidth,  window.innerHeight);
	c.width = c.width;
		for(i=0; i<eventNames.length;i++){
			var meret=70-9*coordinatesZ[i];
			if(meret<10){meret=10;}
			ctx.font=meret+"px Arial";
			var r=0,g,b=194;
			g=Math.floor(50*coordinatesZ[i]);
			if(g>190){
				g=190;
				b-=Math.floor(10*coordinatesZ[i]);
				if(b<0){
					b=0;
					r+=Math.floor(10*coordinatesZ[i]);
					}
				}
			ctx.fillStyle = "rgb("+r+", "+g+", "+b+")";
			var eventNameTemp=eventNames[i];
			if (eventNames[i].length>15) eventNameTemp=eventNameTemp.substr(0,12)+"...";
			ctx.fillText(eventNameTemp,coordinatesX[i]+eltolasX,coordinatesY[i]);
			var metrics = ctx.measureText(eventNameTemp);
    	var txtwidth = metrics.width;
		txtSize[i]=txtwidth;
			eventDatesTemp=eventDates[i];
			
			ctx.font=30/coordinatesZ[i]+"px Arial";
			ctx.fillText(eventDatesTemp,coordinatesX[i]+eltolasX,coordinatesY[i]+30/coordinatesZ[i]);
			
		}
	
}


function getMousePos(c, evt) {
	
        var rect = c.getBoundingClientRect();
        return {
          x: evt.clientX - rect.left,
          y: evt.clientY - rect.top
        };
      }

c.addEventListener('mousemove', function(evt) {
        mousePos = getMousePos(c, evt);
		eventsFocus();
      
      }, false);

function eventsFocus(){

	outFocus();
	var valami;
	for(i=0;i<eventNames.length;i++){

	
	
		if(mousePos.x>coordinatesX[i]+eltolasX){
			if(mousePos.x<coordinatesX[i]+txtSize[i]+eltolasX){
				if( mousePos.y>coordinatesY[i]-70/coordinatesZ[i]){
					if( mousePos.y<coordinatesY[i]){
						//document.getElementById("menu").innerHTML=eventNames[i];
						inFocus(eventNames[i]);
						break;
					}
				}
		}
	}
	
	}

	
	
}
function inFocus(name){
	inFocusName=name;
	var index=eventNames.indexOf(name);
	prevZ=coordinatesZ[index];
	
	if(coordinatesZ[index]!=1){
		coordinatesZ[index]--;
		}
	redraw();
	
	}
function outFocus(){
	
	var index=eventNames.indexOf(inFocusName);
	coordinatesZ[index]=prevZ;
	redraw();
	
	}
	 var eltolasXsebtemp;
function popUp(){
		if (newEventOpen!=0 ){
		newEventOpen=0;
		
		document.getElementById("newEventDiv").innerHTML="";
	
		}
	document.getElementById("signInDiv").innerHTML="";
	if (eltolasXseb!=0){
	
	eltolasXsebtemp=eltolasXseb;
	}else if(animationOn==1){
		eltolasXseb=eltolasXsebtemp;
		
		}
	
	document.getElementById("eventHolder").innerHTML="";
	var preffff=0;
	for(i=0;i<eventNames.length;i++){

	
	
		if(mousePos.x>coordinatesX[i]+eltolasX){
			if(mousePos.x<coordinatesX[i]+txtSize[i]+eltolasX){
				if( mousePos.y>coordinatesY[i]-70/coordinatesZ[i]){
					if( mousePos.y<coordinatesY[i]){
						var xx;
						var yy;
						if (mousePos.x> window.innerWidth/2){xx=mousePos.x-300}else{xx=mousePos.x}
						if (mousePos.y> window.innerHeight/2){yy=mousePos.y-300}else{yy=mousePos.y}
						eltolasXseb=0;
						document.getElementById("eventHolder").innerHTML="<img src=\"imgcontents/popUp.png\" "+
						"class=\"popUpBgImage\" id=\"popUpBgImageid\" >"+
						"<div id=\"popUpBoxy\" class=\"popUpBoxy\" ></div>";
						document.getElementById('popUpBgImageid').className = "popUpBgImage";
						initPopUp();
						preffff=1;
						break;
					}
				}
		}
	}
	
	}
	
	if(prefOpen==1&&preffff==0){
		document.getElementById("popUpBox").innerHTML="";
		prefOpen=0;
		}
}
var actualID;
function initPopUp(){
	document.getElementById("popUpBoxy").innerHTML="";

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
	document.getElementById('popUpBgImageid').className = "popUpBgImageTransiton";
	window.setTimeout(function(){
    document.getElementById("popUpBoxy").innerHTML=xmlhttp.responseText;
	document.getElementById("meetingName").innerHTML=inFocusName ;
	document.getElementById("eventDateDisplay").innerHTML=eventDates[eventNames.indexOf(inFocusName)];
	document.getElementById("meetingWith").innerHTML=eventGuests[eventNames.indexOf(inFocusName)];
	document.getElementById("locationDisp").innerHTML=eventLocation[eventNames.indexOf(inFocusName)];
	document.getElementById("descDisp").innerHTML=eventDiscription[eventNames.indexOf(inFocusName)];
	actualID=eventID[eventNames.indexOf(inFocusName)];
	
	},500);
    }
  }
xmlhttp.open("GET","textcontents/popup.html",true);
xmlhttp.send();
}
function deleteEvent(){
	
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
   			location.reload();
			
    		}
  		}	
	
		
		var parameters="eventID="+	actualID;
		xmlhttp.open("POST","includes/process_deleteevent.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(parameters);

	
	}	
	

function prefBox(){
	
	if (prefOpen==1){
		
		document.getElementById("popUpBox").innerHTML="";
		prefOpen=0;
		return;
		}
	prefOpen=1;
	document.getElementById("popUpBox").innerHTML="";
	
	document.getElementById("popUpBox").innerHTML="<img src=\"imgcontents/popUp.png\" "+
	" class=\"popUpBgImage\" id=\"popUpBgImageid0\" >"+
	"<div class=\"popUpBoxy\" id=\"popPrefBox\"></div>";
	document.getElementById('popUpBgImageid0').className = "popUpBgImage";
	
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
	document.getElementById('popUpBgImageid0').className = "popUpBgImageTransiton";
	window.setTimeout(function(){
		document.getElementById("popPrefBox").innerHTML=xmlhttp.responseText;
		if (eltolasXseb!=0){
			document.getElementById("animation").checked=true;
			}
			
		if(backgrndprefchanged==1){
			document.getElementById("saveprefchangedtd").innerHTML="<input type=\"button\" value=\"savepreferenceschanged()\"/>";
			
			}
	},500);
   
    }
  }
xmlhttp.open("GET","textcontents/prefbox.html",true);
xmlhttp.send();
	
	}
function animvalt(){
	
	if(document.getElementById("animation").checked==true){
	animationOn=1;
	eltolasXseb=1;
	}else{
			animationOn=0;
			eltolasXseb=0;
		}
	}
	
function prefSugo(){
	document.getElementById("menuHelp").innerHTML="";
	document.getElementById("menuHelp").innerHTML="Preferences";
	}
function envSugo(){
	document.getElementById("menuHelp").innerHTML="";
	document.getElementById("menuHelp").innerHTML="Messages";
	}
function profSugo(){
	document.getElementById("menuHelp").innerHTML="";
	document.getElementById("menuHelp").innerHTML="Profile";
	}
function newEventSugo(){
	document.getElementById("menuHelp").innerHTML="";
	document.getElementById("menuHelp").innerHTML="Add new event";
	}
function delSugoText(){
	document.getElementById("menuHelp").innerHTML="";
	}
</script>

<script>
var backgrndprefchanged=0;
function changeBackgroundToColor(color){
	backgrndprefchanged=1;
	document.getElementById("saveprefchangedtd").innerHTML="<input type=\"button\" onclick=\"savepreferenceschanged()\" value=\"save\"/>";
	switch(color){
		case 0:
		document.getElementById("evCanvas").style.background="";
	document.getElementById("evCanvas").style.background="black";
	break;
	case 1:
	document.getElementById("evCanvas").style.background="";
	document.getElementById("evCanvas").style.background="grey";
	break;
	case 2:
	document.getElementById("evCanvas").style.background="";
	document.getElementById("evCanvas").style.background="azure";
	break;
	case 3:
	document.getElementById("evCanvas").style.background="";
	document.getElementById("evCanvas").style.background="white";
	break;
	case 4:
	document.getElementById("evCanvas").style.background="";
	document.getElementById("evCanvas").style.background="red";
	break;
	}
}
/*
function savepreferenceschanged(){
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
	if(xmlhttp.responseText=='ok'){
		document.getElementById("saveprefchangedtd").innerHTML="save successfull";
		}else{
			document.getElementById("saveprefchangedtd").innerHTML="something went wrong:(";
			}
    }
  }
		var parameters="color="+mail+"&img="+p+"&img="+p;
		xmlhttp.open("POST","includes/saveprefchanged.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(parameters);
	
	}
*/
var dragTimer;
var dragBeginX;
function dragEventsScroll(){
	dragBeginX=mousePos.x;
	dragTimer=setInterval("dragReload()",70);
	}
	
function dragReload(){
		for(i=0;i<eventNames.length;i++){
			coordinatesX[i]-=dragBeginX-mousePos.x;
			}
			dragBeginX=mousePos.x;
	}
function dragEventsScrollend(){
	window.clearInterval(dragTimer);
	}
	
	
</script>

</body>
</html>
