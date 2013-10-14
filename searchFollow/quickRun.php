<?php
/*
 * Created on 20-Jan-2010
 * Author :	liju
 * File:	quickRun.php
 *
 */
?>
 <link href="../css/main.css" rel="stylesheet" type="text/css" />
 <?php
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
$getIDs = getUserPASSId($_POST['name']);
/**
 * Finding Keyword id
 */
$dt=date('Y-m-d H:i:s');
$keywordId = getkeyword($_POST['keyid']);
$newKeywordId = $keywordId[0]['KeyId'];
/**
 * getting user from key
 */
//echo urlencode($_POST['message']);
$users = getKeywordUser($_POST['campainID'], $newKeywordId);
if (count($users) != 0) {
	/**
	 * search tweets from database
	 */
   if($users[0]['FollowCount']==1)
		{
			$flwcnt=1500;
		}
		else
		{
			$flwcnt=$users['FollowCount'];
		}
	$tweetsFromDatabase = getKeyWordMessages($newKeywordId, $flwcnt, $users[0]['FollowType']);
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
		$friend = array ();
		if ($getIDs[0]['type'] == 'no') {
			$friend = $connection->get('http://twitter.com/statuses/friends.json');
			addapistatinfo("quickrun","statuses/friends",$_POST['name'], $dt); 
		}
		elseif ($getIDs[0]['type'] == 'yes') {
			$friend = $summize->friends();
			addapistatinfo("quickrun","statuses/friends",$_POST['name'], $dt);
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
			 * follow 10 person during quick run
			 */
			$frCount = 1;
			$i = 0;
			do {
				if (!in_array($tweetsFromDatabase[$i][from_user], $friend)) {
					if ($getIDs[0]['type'] == 'no') {
						addapistatinfo("quickrun","friendships/exists",$_POST['name'], $dt);
						$url = "http://twitter.com/friendships/exists.json";
						$parameters = array (
							'user_a' => $_POST['name'],
							'user_b' => $tweetsFromDatabase[$i]['from_user']
						);
						if ($connection->get($url, $parameters) == 0) {
							$url = "http://twitter.com/friendships/create/{$tweetsFromDatabase[$i]['from_user']}.json";
							addapistatinfo("quickrun","friendships/create",$_POST['name'], $dt);
							$fr_results = $connection->post($url);
							array_push($friend, $tweetsFromDatabase[$i]['from_user']);
						}
					} else {
						addapistatinfo("quickrun","friendships/exists",$_POST['name'], $dt);
						$fri_status = $summize->isFriend($_POST['name'], $tweetsFromDatabase[$i]['from_user']);
						if ($fri_status == false || $fri_status == 0) {
							$fr_results = $summize->followUser($tweetsFromDatabase[$i]['from_user']);
							addapistatinfo("quickrun","friendships/create",$_POST['name'], $dt);
							array_push($friend, $tweetsFromDatabase[$i]['from_user']);
						}
					}
					$frCount++;
					addDeleteFollower('follow', $tweetsFromDatabase[$i]['from_user'], $_POST['name'], $_POST['campainID']);
				}
				$i++;
			} while ($frCount <= 10 && $i < $totalCountfromDB);
			/**
			 * display to page
			 */
			$html1 = displayQuickrunfrmdb($totalCountfromDB, $tweetsFromDatabase, $getIDs, $friend, true, $_POST['campainID'], $keywordId[0]['Message'], $_POST['keyid']);
			$html .= $html1;
			} else {
			/**
			 * live search
			 */
			$liveresults = quickRun($getIDs[0], 1, urlencode($_POST['message']), $users[0]);
			echo $users[0]['FollowCount'];
			$results = objectToArray($liveresults);
			$resultCount = count($results["results"]);
						/**
			 * follow 10 person during quick run
			 */
			$frCount = 1;
			$i = 0;
			for ($i = 0; $i < $resultCount; $i++) {
				$results["results"][$i]['created_at'] = strtotime($results["results"][$i]['created_at']);
			}
			/**
			 * sorting array
			 */
			//added by divya
			if($resultCount>0)
			{
			multi2dSortAsc($results["results"], 'created_at');
			}
			/**
			 * add to keyword message
			 */
			for ($i = 0; $i < $resultCount; $i++) {
			/*	echo "results";
				print "<pre>";
				print_r($results["results"][$i]);
				print "</pre>";*/
				addkeywordMessage($results["results"][$i], $newKeywordId);
			}
			/*do {
				if (!in_array($results[$i][from_user], $friend)) {
					if ($getIDs[0]['type'] == 'no') {
						$url = "http://twitter.com/friendships/exists.json";
						$parameters = array (
							'user_a' => $_POST['name'],
							'user_b' => $results[$i]['from_user']
						);
						if ($connection->get($url, $parameters) == 0) {
							$url = "http://twitter.com/friendships/create/{$results[$i]['from_user']}.json";
							$fr_results = $connection->post($url);
							array_push($friend, $results[$i]['from_user']);
						}
					} else {
						$fri_status = $summize->isFriend($_POST['name'], $results[$i]['from_user']);
						if ($fri_status == false || $fri_status == 0) {
							$fr_results = $summize->followUser($results[$i]['from_user']);
							array_push($friend, $results[$i]['from_user']);
						}
					}
					if ($getIDs[0]['type'] == 'no') {
						$url = "http://twitter.com/friendships/create/{$results[$i]['from_user']}.json";
						$fr_results = $connection->post($url);
					} else {
						$fr_results = $summize->followUser($results[$i]['from_user']);
					}
					$frCount++;
					addDeleteFollower('follow', $results[$i]['from_user'], $_POST['name'], $_POST['campainID']);
				}
				$i++;
			} while ($frCount <= 10 && $i < $resultCount);*/
			
			while ($frCount <= 10 && $i < $resultCount)
			 {
				if (!in_array($results["results"][$i][from_user], $friend)) {
					if ($getIDs[0]['type'] == 'no') {
						addapistatinfo("quickrun","friendships/exists",$_POST['name'], $dt);
						$url = "http://twitter.com/friendships/exists.json";
						$parameters = array (
							'user_a' => $_POST['name'],
							'user_b' => $results["results"][$i]['from_user']
						);
						if ($connection->get($url, $parameters) == 0) {
							addapistatinfo("quickrun","friendships/create",$_POST['name'], $dt);
							$url = "http://twitter.com/friendships/create/{$results["results"][$i]['from_user']}.json";
							$fr_results = $connection->post($url);
							array_push($friend, $results["results"][$i]['from_user']);
						}
					} else {
						$fri_status = $summize->isFriend($_POST['name'], $results["results"][$i]['from_user']);
						if ($fri_status == false || $fri_status == 0) {
							addapistatinfo("quickrun","friendships/create",$_POST['name'], $dt);
							$fr_results = $summize->followUser($results["results"][$i]['from_user']);
							array_push($friend, $results["results"][$i]['from_user']);
						}
					}
					if ($getIDs[0]['type'] == 'no') {
						addapistatinfo("quickrun","friendships/create",$_POST['name'], $dt);
						$url = "http://twitter.com/friendships/create/{$results["results"][$i]['from_user']}.json";
						$fr_results = $connection->post($url);
					} else {
						addapistatinfo("quickrun","friendships/create",$_POST['name'], $dt);
						$fr_results = $summize->followUser($results["results"][$i]['from_user']);
					}
					$frCount++;
					addDeleteFollower('follow', $results["results"][$i]['from_user'], $_POST['name'], $_POST['campainID']);
				}
				$i++;
			} 
			/**
			 * display to page
			 */
			$html1 = displayQuickrun($resultCount, $results, $getIDs, $friend, false, $_POST['campainID'], $keywordId[0]['Message'], urlencode($_POST['message']));
			setToArray($results["results"], $keywordMessages);
			$html .= $html1;
		}
		$html .= '<div style=float:right id=' . $_POST['message'] . 'counter></div>';
	}
	print $html;
	/**
	 * finding total search count
	 */
	$keywordMessageCount = count($keywordMessages);
	/**
	 * sorting array in created_at asc
	 */
	if($keywordMessageCount>0)
			{
	multi2dSortAsc($keywordMessages, 'created_at');
			}
	/**
	 * saving to database
	 */
	for ($i = 0; $i < $keywordMessageCount; $i++) {
		addkeywordMessage($keywordMessages[$i], $newKeywordId);
	}
}
/**
 * display quick run
 * @var $getIDs Id and Passwords
 * @var $page twitter search page number
 * @var $message search word/term
 * @var $users
 */
function quickRun($getIDs, $page, $message, $users) {
	$dt=date('Y-m-d H:i:s');
	if ($getIDs['type'] == 'no') {
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $getIDs[0]['key'], $getIDs[0]['secretkey']);
	}
	elseif ($getIDs['type'] == 'yes') {
		$summize = new summize($_POST['name'], $getIDs[0]['secretkey']);
	}
	if ($getIDs['type'] == 'no') {
		if($users['FollowCount']==1)
			{
				$flwcnt=1500;
			}
		else
			{
				$flwcnt=$users['FollowCount'];
			}
		echo $url = "http://search.twitter.com/search.json";
		$parameters = array (
			'q' => $message,
			'rpp' => $flwcnt,
			'lang' => $users['Lang'],
			'page' => $page
		);
		addapistatinfo("quickrun","search.twitter.com/search",$_POST['name'], $dt);
		$results = $connection->get($url, $parameters);
	}
	elseif ($getIDs['type'] == 'yes') {
	 addapistatinfo("quickrun","search.twitter.com/search",$_POST['name'], $dt);
	 $results = $summize->search($message,$flwcnt,$users['Lang'], $page);
		}
	return $results;
}