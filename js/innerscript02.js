
var c=document.getElementById("evCanvas");
var ctx=c.getContext("2d");
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
					  }
					  catch (err)
        			  {
						 break;
						  }
				
	
				}
				
			 calculatePositions(eventNames);
    		}
  		}	
	
		
		var parameters="fromdate=" + '1990-01-01';
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
	document.getElementById("meetingName").innerHTML=inFocusName;
	document.getElementById("eventDateDisplay").innerHTML=eventDates[eventNames.indexOf(inFocusName)];
	document.getElementById("meetingWith").innerHTML=eventGuests[eventNames.indexOf(inFocusName)];
	document.getElementById("locationDisp").innerHTML=eventLocation[eventNames.indexOf(inFocusName)];
	document.getElementById("descDisp").innerHTML=eventDiscription[eventNames.indexOf(inFocusName)];
	
	},500);
    }
  }
xmlhttp.open("GET","textcontents/popup.html",true);
xmlhttp.send();
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