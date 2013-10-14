<?php
/*
 * Created on 20-Jan-2010
 * Author :	liju
 * File:	followingList.php
 *
 */

include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');

/**
 * setting database condition
 */
$dtParameter = "where K.Message='{$_POST['message']}' and KU.CampaignID={$_POST['campainID']} ";
$phpdate = date('Y-m-d');
$dt=date('Y-m-d H:i:s');
if ($_POST['type'] == 'today') {
	$dtParameter .= " and KM.DT LIKE '{$phpdate}%'";
}
/**
 * Finding Keyword id
 */
$keywordId = getkeyword($_POST['keyID']);
$newKeywordId = $keywordId[0]['KeyId'];

/**
 * get user id and passwords
 */
$getIDs = getUserPASSId($_POST['name']);

/**
 * getting user from key
 */

$users = getKeywordUser($_POST['campainID'], $newKeywordId);
/**
 * search tweets from database
 */
//getting the keyword message with date and followcount(200,500...)
$tweetsFromDatabase = getAllKeywordMessage($dtParameter, $users[0]['FollowCount']);

$totalCountfromDB = count($tweetsFromDatabase);
$keywordMessages = array ();
if ($_POST['message']) {
	/**
		 * initilize with twitter Api
		 */
	if ($getIDs[0]['type'] == 'no') {
		include ('../classes/twitteroauth.php');
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $getIDs[0]['key'], $getIDs[0]['secretkey']);
	}
	elseif ($getIDs[0]['type'] == 'yes') {
		include ('../classes/class.twitter.php');
		$summize = new summize($_POST['name'], $getIDs[0]['secretkey']);
		}
	/**
	 * friend list
	 */
	if ($getIDs[0]['type'] == 'no') {
		$friend = array ();
		$friend = $connection->get('http://twitter.com/statuses/friends.json');
		addapistatinfo("searchfollow","statuses/friends",$_POST['name'], $dt); 
	}
	elseif ($getIDs[0]['type'] == 'yes') {
		$friend = $summize->friends();
		addapistatinfo("searchfollow","statuses/friends",$_POST['name'], $dt); 
	}
	$friendcount = count($friend);
	for ($i = 0; $i < $friendcount; $i++) {
		array_push($friend, $friend[$i]->screen_name);
	}
	if ($users[0]['Lang'] == 'any') {
		$users[0]['Lang'] = '';
	}

	/**
	 * check whether to take from DB or live search
	 */
	if ($totalCountfromDB > 0) {
		/**
		 * Iterating results
		 */
		$html1 = displayQuickrunfrmdb($totalCountfromDB, $tweetsFromDatabase, $getIDs, $friend, true, $_POST['campainID'],$keywordId[0]['Message'], $_POST['keyID']);
		$html .= $html1;
	}
	else{
		$html .= '<div style=float:left id=' . $_POST['message'] . 'counter>No Records Found</div>';
	}
}
print $html;
?>