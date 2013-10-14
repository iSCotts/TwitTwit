function validate(theform)
{
	 var imagePath = document.addgroup.groupimage.value;
	 var pathLength = imagePath.length;
	 var lastDot = imagePath.lastIndexOf(".");
	 var fileType = imagePath.substring(lastDot,pathLength);
if(theform.groupnametxt.value=="")
{
	document.getElementById('namelbl').innerHTML="Group name required";
	document.getElementById('namelbl').style.visibility = 'visible';
	theform.groupnametxt.focus();
	return false;
	}
document.getElementById('namelbl').innerHTML = "";
document.getElementById('namelbl').style.visibility = 'hidden';
if(document.addgroup.groupimage.value!="")
{
 if((fileType == ".gif") || (fileType == ".jpg") || (fileType == ".jpeg") || (fileType == ".GIF") || (fileType == ".JPG")) {
	 	} else {
	document.getElementById('filelbl').innerHTML="Please select .JPG or .GIF image formats";
	document.getElementById('filelbl').style.visibility = 'visible';
	return false;
	 }
 }
document.getElementById('filelbl').innerHTML = "";
document.getElementById('filelbl').style.visibility = 'hidden';
if(theform.groupdescription.value=="")
{
	document.getElementById('desclbl').innerHTML="Group description required";
	document.getElementById('desclbl').style.visibility = 'visible';
	theform.groupdescription.focus();
	return false;
	}
document.getElementById('desclbl').innerHTML = "";
document.getElementById('desclbl').style.visibility = 'hidden';
return true;
}
    
   function GetXmlHttpObject(handler)  
   {  
     var objXMLHttp=null  
     if (window.XMLHttpRequest)  
     {  
         objXMLHttp=new XMLHttpRequest()  
     }  
     else if (window.ActiveXObject)  
     {  
         objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")  
     }  
     return objXMLHttp  
   }  
     
   function stateChanged()  
   {  
     if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")  
     {  
             // txtResult will be filled with new page  
             document.getElementById("txtResult").innerHTML = xmlHttp.responseText
               }  
     else {  
             //alert(xmlHttp.status);  
     }  
   }  
     
   function htmlData(url,gid,qStr)  
   {  
  	     if (url.length==0)  
     {  
         document.getElementById("txtResult").innerHTML = "";  
         return;  
     }  
     
     xmlHttp = GetXmlHttpObject();  
     
     if (xmlHttp==null)  
     {  
         alert ("Browser does not support HTTP Request");  
         return;  
     }  
     
     url=url+"?"+gid+"&"+qStr;  
     xmlHttp.onreadystatechange = stateChanged;  
     xmlHttp.open("GET",url,true) ;  
   xmlHttp.send(null);  
 }  
   function htmlDatasrch(url,stxt,qStr)  
   {  
  	     if (url.length==0)  
     {  
         document.getElementById("txtResult").innerHTML = "";  
         return;  
     }  
     
     xmlHttp = GetXmlHttpObject();  
     
     if (xmlHttp==null)  
     {  
         alert ("Browser does not support HTTP Request");  
         return;  
     }  
     
     url=url+"?"+stxt+"&"+qStr;  
     xmlHttp.onreadystatechange = stateChanged;  
     xmlHttp.open("GET",url,true) ;  
   xmlHttp.send(null);  
 } 
   
   function stateChanged1()  
   {  
     if (xmlHttp1.readyState==4 || xmlHttp1.readyState=="complete")  
     {  
             // txtResult will be filled with new page  
             document.getElementById("txtResult1").innerHTML = xmlHttp1.responseText
                      }  
     else {  
             //alert(xmlHttp.status);  
     }  
   }  
   function stateChanged2()  
   {  
     if (xmlHttp2.readyState==4 || xmlHttp2.readyState=="complete")  
     {  
             // txtResult will be filled with new page  
             document.getElementById("txtResult2").innerHTML = xmlHttp2.responseText
                  }  
     else {  
             //alert(xmlHttp.status);  
     }  
   }  
     
   function htmlData1(url,un,qStr)  
   {  
  	     if (url.length==0)  
     {  
         document.getElementById("txtResult1").innerHTML = "";  
         return;  
     }  
     
     xmlHttp1 = GetXmlHttpObject();  
     
     if (xmlHttp1==null)  
     {  
         alert ("Browser does not support HTTP Request");  
         return;  
     }  
     
     url=url+"?"+un+"&"+qStr;  
     xmlHttp1.onreadystatechange = stateChanged1;  
     xmlHttp1.open("GET",url,true) ;  
   xmlHttp1.send(null);  
 }  
   function htmlData2(url,un,qStr)  
   {  
  	     if (url.length==0)  
     {  
         document.getElementById("txtResult2").innerHTML = "";  
         return;  
     }  
     
     xmlHttp2 = GetXmlHttpObject();  
     
     if (xmlHttp2==null)  
     {  
         alert ("Browser does not support HTTP Request");  
         return;  
     }  
     
     url=url+"?"+un+"&"+qStr;  
     xmlHttp2.onreadystatechange = stateChanged2;  
     xmlHttp2.open("GET",url,true) ;  
   xmlHttp2.send(null);  
 }  
function popitup(url) {
	newwindow=window.open(url,'name','height=600,width=900');
	if (window.focus) {newwindow.focus()}
	return false;
}
