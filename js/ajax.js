/*
 * Ajax function for changing the Mail template
 */


var xmlHttp;
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}



 
 


function changeTemplate(content) {
	var id = document.getElementById('name').value;
	var subject = document.getElementById('subject').value;
	var saluation = document.getElementById('saluation').value;
	var signature = document.getElementById('signature').value;
	var signaturename = document.getElementById('signaturename').value;
	$.ajax( {
		url : "ajaxChangeMailTemplate.php?id=" + id+"&subject="+subject+"&content="+content+"&saluation="+saluation+"&signature="+signature+"&signaturename="+signaturename,
		cache : false,
		success : function(response) {
			$("#contents").html(response);
		}
	});
}

function checkURLtest(){
	 
	$("#feed_urlstatus_red").html('');
	$("#feed_urlstatus_green").html(' ');
	
	
	$("#feed_urlstatus").html('Please wait...');
	var url=document.getElementById('feed_feedurl').value;
	 
	 
	$.ajax( {
		url : "../feed/ajaxfeedUrlCheck.php?url=" + url,
		cache : false,
		success : function(response) {
		 
		
		 var splitresult = response.split("!");
		 
		 
			var message = splitresult[0];
			var updatedurl = splitresult[1];
		
		   
		 
			if(message == "fine"){
			 
			//$("#feed_urlstatus").html('URL Check successfully');
				//$("#feed_urlstatus").html('<font color=green>This is a valid RSS feed</font>');
				
				$("#feed_urlstatus_green").html('<font color=green>This is a valid RSS feed</font>');
				$("#feed_urlstatus").html(' ');
				$("#feed_urlstatus_red").html('');
				
			document.getElementById("feed_feedurl").value = updatedurl;
			
			document.getElementById("xx").disabled = false;
			//document.getElementById("dislaysubmitid").innerHTML = "";
			
			}
			else{
			//	$("#feed_urlstatus").html(response);
				//$("#feed_urlstatus").html('<font color=red>This is not a valid RSS feed</font>');
				
				$("#feed_urlstatus_red").html('This is not a valid RSS feed');
				$("#feed_urlstatus").html(' ');
				$("#feed_urlstatus_green").html(' ');
				
				document.getElementById("xx").disabled = true;
				}
			
		}
	});
	
}

function removeuserid(userid)
{
 
	var userid = userid.split('-')
	var displayid = "ShowselectedUsers"+userid[1];
	document.getElementById(displayid).innerHTML = '';
}
function GetUserId(userid)
{
	var original = userid;
	
	var userid = userid.split('-');
	
	var displayid = "ShowselectedUsers"+userid[1];
	
	 var format ="<input type=hidden name=uname[] value="+ userid[0]+">Selected User :"+ userid[0]+"<a onclick=removeuserid('"+original+"')>Remove</a>";
	 
 
	document.getElementById(displayid).innerHTML = format;
	
}

 
