<?php
session_start();

$_SESSION["selectedarray"]  = "";





if($_REQUEST["id"] == "settings"){
	$_SESSION["selectedarray"]  = "s";
	
}


else if($_REQUEST["id"] == "addaccounts"){
	$_SESSION["selectedarray"]  = "a";
	
}

else if($_REQUEST["id"] == "keywords"){
	$_SESSION["selectedarray"]  = "k";
	}

else if($_REQUEST["id"] == "feeds"){
	$_SESSION["selectedarray"]  = "f";
	
}

else if($_REQUEST["id"] == "autotweet"){
	$_SESSION["selectedarray"]  = "t";
	
}

else if($_REQUEST["id"] == "tracklinks"){
	$_SESSION["selectedarray"]  = "tl";
	
}

else if($_REQUEST["id"] == "trackcampaigns"){
	$_SESSION["selectedarray"]  = "tc";
	
}


 else
 {
 	
 }
		
		