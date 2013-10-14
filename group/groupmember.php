<?php
session_start();
include_once "../config/configoriginal.php";
include_once "../classes/dbClient.php";
include_once "../common/sqlFunctions.php";
if(isset($_SESSION["username"]) && ($_SESSION["username"]!= "")){
	if(isset($_REQUEST['leaveid']))
	{
	$leaveid=$_REQUEST['leaveid'];
	$gid=$_REQUEST['id'];
	$leavesql = "delete  FROM `ta_group_members` where memberID='$leaveid'";
	$Getdeletelist = runQuery($leavesql);	
	header("Location:grouphome?act=7&id=$gid");
	exit;	
	}
	
	    $groupid=$_REQUEST[groupid];
	    $membername=$_SESSION["username"];
	    
		$membernamealreadyexits = "SELECT count(*) FROM `ta_group_members` WHERE memberName='$membername' and groupID='$groupid'";
		//echo $groupnamealreadyexits;
		$membernamealreadyexitsresult  =  mysql_query($membernamealreadyexits);
		$membernamealreadyexitsresult=mysql_fetch_array($membernamealreadyexitsresult);
		if($membernamealreadyexitsresult[0][0] == 0){
				
		$createdate =date("Y-m-d");
		
		$sql ="INSERT INTO `ta_group_members` (`groupID` ,`memberName`,`memberjDate`)
VALUES ( '$groupid', '$membername', '$createdate');";
				
		$Insertgresult  =  runQuery($sql);
		//query for following on the group members
		$sqlfollowselect="select * from  `ta_group_members` where groupID='$groupid'";
		$membresult  =   runQuery($sqlfollowselect);
		if(count($membresult)>=1)
				{
			for($y=0;$y<count($membresult);$y++){
				$groupmember=$membresult[$y]["memberName"];
				//check whether the record is already exists or not
				$sqlfollowexists="select * from  `ta_group_follow` where groupID='$groupid' and userfollow='$membername' and userTofollow='$groupmember'";
				$membexistsresult  =   runQuery($sqlfollowexists);
					if(count($membexistsresult)<1)
						{
						if($groupmember!=$membername)
							{
						$sqlfollowinsert ="INSERT INTO `ta_group_follow` (`groupID` ,`userfollow`,`userTofollow`)
					VALUES ( '$groupid', '$membername', '$groupmember');";	
							$result=runQuery($sqlfollowinsert);			
							}
						}
					}
				}
	//redirecting to the grouphome page after insertion
	header("Location:grouphome?act=5&id=$groupid");	
				}
				else
		  {
		  	header("Location:grouphome?act=6&id=$groupid");	
		    //$ErrorMessage = "you are already exists in this group";
		    }
	}
else{
	header("Location:../index");
}

?>
