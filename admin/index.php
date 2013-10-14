<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Twitacc Admin Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<link
	href="../css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script
	src="../js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $("#adminlogin").validate({
        rules: {
    	  username: "required",// simple rule, converted to {required:true}
          password:"required",// simple rule, converted to {required:true}
          email: {// compound rule
          required: true,
          email: true
        },
        },
        
      });
    });
  </script>
</head>

<body>
<?php

 $GetErrorCode = $_REQUEST["act"];
 if($GetErrorCode == 1)
 $ErrorMessage = "Invalid Username/Password";
 if($GetErrorCode == 2)
 $ErrorMessage = "You are logged Out ! ";
  if($GetErrorCode == 3)
 $ErrorMessage = "Your Session Out, ReLogin ";
 if($GetErrorCode == 4)
 $ErrorMessage = "Password Changed , Re Login ";
 

?>



 <form id="adminlogin"  name="adminlogin" action="index_action.php" method="post">
 




 <table cellpadding="2" cellspacing="2" border="0" align="center"  >

<tr >
<td colspan="2" align="center" height="150"></td>
</tr>

<tr >
<td colspan="2" align="center">Twitacc Admin Login </td>
</tr>


<tr >
<td colspan="2" align="center"><?php print $ErrorMessage ?> </td>
</tr>

 <tr><td>Username</td>
 <td><input
	type="text" name="username" value="" /> </td></tr>

 <tr><td>  Password   </td><td> <input
	type="password" name="password" />  </td></tr>
 
 
 
 
<tr><td colspan="2" align="center"> <input   type="submit" name="login"
	value="Login" ></td></tr>
	
 




</table>


</form>


 
</body>
</html>
