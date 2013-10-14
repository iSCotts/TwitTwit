<?php
/*
 * Created on 22-March-2010
 * Author :	Divya
 * File:	follow.php
 * Purpose: For following group members
 */
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
include_once ('../classes/class.twitter.php');
if ((int) $_REQUEST['name'] != 0) {
	$usrname = getUserName($_REQUEST['name']);
	$userName = $usrname[0]['UserName'];
} else {
	$userName = $_REQUEST['name'];
}
$getIDs = getUserPASSId($userName);
$dt=date('Y-m-d H:i:s');
/**
 * initilize with twitter Api
 */
if ($getIDs[0]['type'] == 'no') {
	include ('../classes/twitteroauth.php');
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $getIDs[0]['key'], $getIDs[0]['secretkey']);
}
elseif ($getIDs[0]['type'] == 'yes') {
	include_once ('../classes/class.twitter.php');
	$summize = new summize($userName, $getIDs[0]['secretkey']);
}
/**
* if follow unfollow user
* else follow user
*/
if ($_REQUEST['type'] == 'follow') {
	$html = "remove";
	$html1 = "Unfollow";
	$img="<img src=\"../images/remove-user.png\" alt=\"\" />";
	if ($getIDs[0]['type'] == 'no') {
		$url = "http://twitter.com/friendships/create/{$_REQUEST['user']}.json";
		$results = $connection->post($url);
	} else {
		$results = $summize->followUser($_REQUEST['user']);
	}
		addapistatinfo("groupfollow","friendships/create",$userName, $dt); 
	}
elseif ($_REQUEST['type'] == 'remove') {

	$html = "follow";
	$html1 = "Follow";
	$img="<img src=\"../images/add_user.png\" alt=\"\" />";
	if ($getIDs[0]['type'] == 'no') {
		$url = "http://twitter.com/friendships/destroy/{$_REQUEST['user']}.json";
		$results = $connection->post($url);
	} else {
		$results = $summize->leaveUser($_REQUEST['user']);
	}
	addapistatinfo("groupunfollow","friendships/destroy",$userName, $dt);
}
if($_REQUEST['btype']=="block")
{
	$followstatus="";
}
else{
$val = "onclick=\"groupfollowstatus('{$html}','{$_REQUEST[name]}','follow{$_REQUEST[user]}','{$_REQUEST[user]}');\"";

$followstatus = "<a {$val} title=\"Click to {$html1} {$_REQUEST[user]}\">{$img}</a>";
}
echo $followstatus;
?>
