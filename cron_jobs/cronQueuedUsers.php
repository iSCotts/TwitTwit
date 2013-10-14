<?php
/*
 * Created on 9-June-2010
  * File:	cronQueuedUsers.php
 *
 */
include_once ('../searchFollow/cronCommon.php');
include_once ('../searchFollow/cronClasses.php');
include_once ('../classes/class.twitter.php');
$userName="cron";
$dt=date('Y-m-d H:i:s');

$db_UF_Limit 	= dkGetCommonSettings('user-keyword-follow-limit');
$x_userList = getQueuedUserListDistinct();
for ($k = 0; $k < count($x_userList); $k++) 
{	
$x_count		= 0;
$counter=0;
do
{
 // echo '<br/> limit'.($db_UF_Limit-$x_count);
  $userList = getQueuedUserList($x_userList[$k]['user_name'],$db_UF_Limit-$x_count);
  $x_count+= count($userList);
  $twitterFollowOverFlag = false;
for ($i = 0; $i < count($userList); $i++) 
{	
	echo '<br/>-------------------------------------------------------------------------------------------';
	echo '<br/>'.$userList[$i]['user_name'];
	$followedCount = dkGetUserFollowCount($userList[$i]['UserID']);
	$followLimit   = dkGetCommonSettings('follow_user_limt');
	if($followedCount>=$followLimit) continue;
	//$dkRateLimit = 0;
	//validation using Keys
	$followFriend = new SearchFollowAPI($userList[$i]['key'], $userList[$i]['secretkey']);
	//echo '<br/> Ratelimit:'.$dkRateLimit =$followFriend->dkratelimitskey();
	//if($dkRateLimit<$uPRateLimit) continue;
	$followed=$followFriend->followUser($userList[$i]['follow_user_name']);
			$rTemp = get_object_vars($followed);
			$dkFindTemp = 'You are unable to follow more people at this time';
			if(strpos($rTemp['error'],$dkFindTemp))
			{
				echo '<br/> Twitter Error: '.$dkFindTemp.'<br/> Exit 1';
				$twitterFollowOverFlag = true;
				break;
			}
		 dkLogQueuedFollowedUser($userList[$i]['UserID'],$userList[$i]['user_name'],$userList[$i]['follow_user_name'],$userList[$i]['key_id'],$userList[$i]['profile_image_url'],$userList[$i]['text']);
		 addapistatinfo1("cronQueuedUsers","friendships/create",$userName, $dt); 
		  clearQueuedUser($userList[$i]['user_name'],$userList[$i]['follow_user_name']);
		 if($twitterFollowOverFlag)
		{
			echo ' | Exit 2';
			$twitterFollowOverFlag = false;
			break;
		}
	}
	$counter++;
} while(($x_count<$db_UF_Limit) &&($counter<$db_UF_Limit) );
}
?>
