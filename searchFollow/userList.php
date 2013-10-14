<?php
/*
 * Created on 02-Feb-2010
 * Author :	liju
 * File:	userList.php
 *
 */
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');



$userList=getAutoTextUserName($_GET['userID'],$_GET['q'],$_GET['campaignId']);
$userListCount=count($userList);
if($userListCount==0){
	echo "NO USERS";
}else{
for($i=0;$i<$userListCount;$i++){
	echo "{$userList[$i]['from_user']} \n";
}
}
?>
