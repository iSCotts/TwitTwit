<?php
ob_start();
session_start();
if (isset($_SESSION["username"])) {
	if (isset($_SESSION["mailid"]))
	{
	unset($_SESSION["mailid"]);
	}
header("Location: home");
}
else{
header("Location: ../index");
}
?>	