<?php
ob_start();
session_start();

/*
 * Created on 28-Dec-2009
 * Author :	root
 * File:	feed.php
 * 
 */


include '../classes/dbClient.php';
include '../common/sqlFunctions.php';

	$feedrowid  = $_REQUEST["feedrowid"];
	
 	if(isset($_REQUEST[posturl]) && ($_REQUEST[posturl] == 1))
	 $posturlstatus =1;
	else
	 $posturlstatus =0;
	 
	 

	 
	 if(isset($_REQUEST[shorturl]) && ($_REQUEST[shorturl] == 1))
	 $shorturlstatus =1;
	else
	 $shorturlstatus =0;
	 
	 
	 

	$userid = getUserId($request['username']);
	$phpdate = date('Y-m-d H:i:s');
	
	
	 $Updatesql = "UPDATE `ta_feeds` SET 
	 
`feedname` = '$_REQUEST[feedname]',
`feedurl` = '$_REQUEST[feedurl]',
`sortid` = '$_REQUEST[sortid]',
`isactive` = '1',
`posturl` = '$posturlstatus',
`shorturl` = '$shorturlstatus',
`freq_id` = '$_REQUEST[freq_id]',
`showdesc` = '$_REQUEST[showdesc]',
`DT` = '$phpdate' WHERE `id` ='$feedrowid'";
	
	$UpdatesqlResult = runQuery($Updatesql);

	
	//print_r($UpdatesqlResult);
	//exit;
	
	//if($UpdatesqlResult ==1 )
//	{
	//	include "posttweetsaftercreatedrss.php";
		//print "Updated";
		print "<div class=green>The feed has been Updated</div>";
		
		 
		
	//	header("Location:managefeed?act=5");
		
		
	//}
	
	 
//	else
//	{
		
	//header("Location:edit_feed.php?act=3");
	////}
	
	
	

  
 

  
 

?>
