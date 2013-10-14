<?php
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
$userkeyword = $_REQUEST["q"];
$userList = "SELECT * FROM ta_users WHERE UserName LIKE '$userkeyword%'";
$userList = runQuery($userList);
$userListCount=count($userList);
if($userListCount==0){
	echo "NO USERS";
}else{
for($i=0;$i<$userListCount;$i++){
	 echo "{$userList[$i]['UserName']}"."\n";
}
}
