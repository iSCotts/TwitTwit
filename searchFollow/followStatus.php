<?php
/*
 * Created on 29-Jan-2010
 * Author :	liju
 * File:	followStatus.php
 *
 */
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
//addDeleteFollower($_POST['status'], $_POST['message'], $_POST['name'],$_POST['campainID']);

$getUserCount=getKeywordUsers($_POST['campainID'],$_POST['name'],$_POST['keyID']);
//echo ($getUserCount[0]['Followers']>0)?$getUserCount[0]['Followers']:'0';
 if(selectfollowcount($getUserCount[0]['UserId'],$getUserCount[0]['id'])> 0) { echo $follow =selectfollowcount($getUserCount[0]['UserId'],$getUserCount[0]['id']); } else { echo $follow = '0'; };
?>
