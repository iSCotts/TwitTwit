<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Unfollow Tool</title>

<link href="../css/home.css" rel="stylesheet" type="text/css" />

<link href="../css/main.css" rel="stylesheet" type="text/css" />

  <style>

   a {

    color: #333;

    text-decoration: none;

   }

   a:hover {

    text-decoration: underline;

   }

   a.selected {

    font-weight: bold;

    text-decoration: underline;

   }

   .numbers {

    line-height: 20px;

    word-spacing: 4px;

   }

   .group_userfollowing {

    margin:60px 0 0 20px;

	padding:10px;

	width:840px;

	height: auto;

	background:url(../images/gshad-in.png) repeat;

	}

	.group_userfollowing01 {

	margin:5px 0 0 0;

	padding:0 0 0 0;

	width:835px;

	height:auto;

	}

	.group_userfollowing01 ul {

	padding:0 0 0 5px;

	margin:0 0 0 0;

	list-style:none;

	}

	.group_userfollowing01 li {

	padding:0 2px 0 3px;

	margin:0 0 0 0;

	float:left;

	}






  </style>

 </head>



<body onLoad="init()"> 

<div id="loading" style="position:absolute; width:100%; text-align:center; top:300px;"><img src="../images/loading-first.gif" border=0></div> 

<script> 

var ld=(document.all);

 

var ns4=document.layers;

var ns6=document.getElementById&&!document.all;

var ie4=document.all;

 

if (ns4)

	ld=document.loading;

else if (ns6)

	ld=document.getElementById("loading").style;

else if (ie4)

	ld=document.all.loading.style;

 

function init()

{

if(ns4){ld.visibility="hidden";}

else if (ns6||ie4) ld.display="none";

}

</script> 
<!--<iframe src="http://www.twitjix.com/user/automated_unfollow_settings.php" frameborder="0"  width="100%" height="220px" scrolling="no" >
</iframe>-->
<iframe src="http://www.twitjix.com/searchFollow/friends_not_following_you.php" frameborder="0"  width="100%" height="600px" scrolling="no" >
</iframe>

</body>

</html>

