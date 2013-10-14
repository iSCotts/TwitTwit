<?php
ob_start();
session_start();
$_SESSION["uname"] = "";
session_destroy();
header("Location:index.php?act=2");
exit;
		
?>