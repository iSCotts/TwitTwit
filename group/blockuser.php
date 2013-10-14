<?php
/*
 * Created on 24-March-2010
 * Author :	Divya
 * File:	blockuser.php
 * Purpose: For blocking group members
 */
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
$btype=$_REQUEST['btype'];
$ftype=$_REQUEST['ftype'];
$name=$_REQUEST['name']; 
$user=$_REQUEST['user']; 
$spanid=$_REQUEST['spanid']; 
$groupID=$_REQUEST['groupID'];
$dt = date('Y-m-d');
/**
* if block unblock user
* else block user
*/

if ($_REQUEST['btype'] == 'block') {
	$html = "unblock";
	$ftype="follow";
	$img="unblock";
	$insertblock="insert into ta_block_user(groupID,blockedby,blockeduser,bdate) values ('$groupID','{$name}','{$user}','{$dt}');";
    executeQuery($insertblock);
	}
elseif ($_REQUEST['btype'] == 'unblock') {

	$html = "block";
	$ftype="remove";
	$img="<img src=\"../images/pause-user.png\" alt=\"\" />";
	//$sqldel = "delete  FROM `ta_block_user` where groupID='$groupID' and blockedby='$name' and blockeduser='$user'";
	$sqldel = "delete  FROM `ta_block_user` where blockedby='$name' and blockeduser='$user'";
	$Getdeletelist = runQuery($sqldel);
}
//$val = "onclick=\"groupblockuser('{$html}','{$_REQUEST[name]}','follow{$_REQUEST[user]}','{$_REQUEST[user]}');\"";
$blockuser="<a onclick=\"groupblockuser('{$html}','{$ftype}','{$name}','block{$user}','follow{$user}','{$user}','{$groupID}');\"  title=\"Click to {$html} {$user}\">$img</a>";
//$blockuser = "<a {$val} title=\"Click to {$html1} {$result->from_user}\">{$img}</a>";
echo $blockuser;
?>
