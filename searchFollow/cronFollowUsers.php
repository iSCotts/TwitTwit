<?php
/*
 * Created on 30-Jan-2010
 * Author :	liju
 * File:	cronFollowUsers.php
 *
 */
include ('cronCommon.php');
include ('cronClasses.php');
include_once ('../classes/class.twitter.php');
$userName="cron";
$dt=date('Y-m-d H:i:s');
$userList = getUserList();
$uPRateLimit = dkGetCommonSettings('follow_user_rate_limt');
$twitterFollowOverFlag = false;
for ($i = 0; $i < count($userList); $i++) 
{	
	echo '<br/>-------------------------------------------------------------------------------------------';
	echo '<br/>'.$userList[$i]['Username'];
	$followedCount = dkGetUserFollowCount($userList[$i]['UserID']);
	$followLimit   = dkGetCommonSettings('follow_user_limt');
	if($followedCount>=$followLimit) continue;
	//$dkRateLimit = 0;
	//validation using Keys
	$followFriend = new SearchFollowAPI($userList[$i]['key'], $userList[$i]['secretkey']);
	//echo '<br/> Ratelimit:'.$dkRateLimit =$followFriend->dkratelimitskey();
	//if($dkRateLimit<$uPRateLimit) continue;
	$keywords = getkeyWordList($userList[$i]['UserID']);
	echo ' | keywords: '.$keywordsCount = count($keywords);
	if($keywordsCount ==0) continue;
	for ($j = 0; $j < $keywordsCount; $j++) 
	{
		if(selectfollowcount($keywords[$j]['UserID'],$keywords[$j]['id'])>=$keywords[$j]['FollowCount']) continue;
		echo '<br/>  keyId: '.$keywords[$j]['keyId'];
		// get keywords all details with specified keyword for the user
		$keywordUsers = keyWordUsers($userList[$i]['UserID'], $keywords[$j]['keyId']);
		echo ' | Users: '.count($keywordUsers);
		if (count($keywordUsers) == 0) continue;
		for ($k = 0; $k < count($keywordUsers); $k++) 
		{
			$followed=$followFriend->followUser($keywordUsers[$k]['from_user']);
			$rTemp = get_object_vars($followed);
			$dkFindTemp = 'You are unable to follow more people at this time';
			if(strpos($rTemp['error'],$dkFindTemp))
			{
				echo '<br/> Twitter Error: '.$dkFindTemp.'<br/> Exit 1';
				$twitterFollowOverFlag = true;
				break;
			}
			dkLogFollowedUser($userList[$i]['UserID'],$keywords[$j]['id']);
			addapistatinfo1("cronfollowusers","friendships/create",$userName, $dt); 
			saveFollowers($keywordUsers[$k]['MessageID'], $userList[$i]['UserID'], $keywords[$j]['keyId']);
		}
		if($twitterFollowOverFlag)
		{
			echo ' | Exit 2';
			$twitterFollowOverFlag = false;
			break;
		}
		setKeywordfollowersForUser($keywords[$j]['CampaignID'], $keywords[$j]['keyId'], $userList[$i]['UserID']);
	}

}

?>
