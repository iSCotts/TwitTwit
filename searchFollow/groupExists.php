<?php
/*
 * Created on 23-march-2010
 * Author :	Divya
 * File:	groupExists.php
 *
 */
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
$keyword=$_REQUEST['keyword'];
$sql ="SELECT * FROM `ta_group` WHERE groupName = '{$keyword}'";
$groupDetail = runQuery($sql);
$gid=$groupDetail[0]['groupID'];
if($groupDetail[0]['groupName']) {
header("location:../group/grouphome?id=$gid");
}
else{
header("location:../group/index");
}
?>
