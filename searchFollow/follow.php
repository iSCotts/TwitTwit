<?php
/*
 * Created on 21-Jan-2010
 * Author :	liju
 * File:	follow.php
 *
 */
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
include_once ('../classes/class.twitter.php');
if ((int) $_POST['name'] != 0) {
	$usrname = getUserName($_POST['name']);
	$userName = $usrname[0]['UserName'];
} else {
	$userName = $_POST['name'];
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
if ($_POST['type'] == 'follow') {
	$html = "remove";
	$html1 = "Unfollow";
	$img="<img src=\"../images/unfollow.png\" alt=\"\" />";
	if ($getIDs[0]['type'] == 'no') {
		$url = "http://twitter.com/friendships/create/{$_POST['user']}.json";
		$results = $connection->post($url);
		} else {
		$results = $summize->followUser($_POST['user']);
			    }
	addapistatinfo("follow","friendships/create",$userName, $dt);
}
elseif ($_POST['type'] == 'remove') {

	$html = "follow";
	$html1 = "Follow";
	$img="<img src=\"../images/follow.png\" alt=\"\" />";
	if ($getIDs[0]['type'] == 'no') {
		$url = "http://twitter.com/friendships/destroy/{$_POST['user']}.json";
		$results = $connection->post($url);
				} else {
		$results = $summize->leaveUser($_POST['user']);
			}
			addapistatinfo("unfollow","friendships/destroy",$userName, $dt); 
		}
		//in sqlfunctions.php
		$rTemp = get_object_vars($results);
    if($rTemp['error']=='')
		{
		addDeleteFollower($_POST['type'], $_POST['user'], $userName, $_POST['campainID']);
		}
$val = "onclick=\"followstatus('{$html}','{$_POST[name]}','follow{$_POST[user]}','{$_POST[user]}','{$_POST['campainID']}','{$_POST['message']}', '{$_POST['keyID']}');\"";


$followstatus = "<a {$val} title=\"Click to {$html1} {$_POST[user]}\">{$img}</a>";
echo $followstatus;
?>
