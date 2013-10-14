<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Twitacc Admin Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<link href="facebox/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<link href="facebox/faceplant.css" media="screen" rel="stylesheet" type="text/css" />
<script	src="js/jquery.js" type="text/javascript"></script>
<script src="../facebox/facebox.js" type="text/javascript"></script>
<script src="../js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loading_image : 'loading.gif',
        close_image   : 'closelabel.gif'
      }) 
    })
  </script>
<script type="text/javascript" src="js/date.js"></script>
<script	type="text/javascript" src="js/jquery.datePicker.js"></script>
<link rel="stylesheet" type="text/css" media="screen" 	href="css/datePicker.css">
<script type="text/javascript">
	/*$(function()
			{
				$('.date-pick').datePicker(
					{
						startDate:  (new Date('01/01/1996')).asString(),
						endDate: (new Date()).asString()
										}
				);
			});*/
  </script>
  
 <style>
body {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	line-height:18px;
	  }
.label {
text-align:right;
}
/* located in demo.css and creates a little calendar icon
 * instead of a text link for "Choose date"
 */
a.dp-choose-date {
	float: left;
	width: 16px;
	height: 16px;
	padding: 0;
	margin: 5px 3px 0;
	display: block;
	text-indent: -2000px;
	overflow: hidden;
	background: url(images/calender.jpg) no-repeat; 
}
a.dp-choose-date.dp-disabled {
	background-position: 0 -20px;
	cursor: default;
}
/* makes the input field shorter once the date picker code
 * has run (to allow space for the calendar icon
 */
input.dp-applied {
	width: 140px;
	float: left;
}
.autotweet07 {
	padding:0 0px 0 15px;
	width:480px;
	height:auto;
	float:left;
	font-size:11px;
	text-align:justify;
}

.textarea_editable {
	width:480px;
	height:30px;
	padding:2px 0 0 2px;
	font-size:12px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td { 
	margin:0;
	padding:0;
}
table {
	border-collapse:collapse;
	border-spacing:0;
}
fieldset,img { 
	border:0;
}
</style>

 
</head>

<body>

<table border="1" cellpadding="2"  cellspacing="2" width="100%">

<tr >
 

<td colspan="3"   width="100%">

<table width="100%" cellpadding="2" cellspacing="2" border="0">
<tr><td colspan="2" align="center"> Welcome To Twitacc Admin Panel</td></tr>
<tr><td> Welcome : <?php print $_SESSION["uname"]?> </td><td align="right"><a href="logout.php">Logout</a></td></tr>
</table>

</td>


</tr>
