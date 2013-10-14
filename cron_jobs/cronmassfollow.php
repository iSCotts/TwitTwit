<?php
/*
 * Created on 07-April-2010
  * File:	cronmassfollow.php
 *
 */
include ('../searchFollow/cronCommon.php');
include ('../searchFollow/cronClasses.php');
include_once ('../classes/class.twitter.php');
//mass following other users friends
$userName="cron";
$dt=date('Y-m-d H:i:s');
$db_UF_Limit 	= dkGetCommonSettings('massfollow_limit');
$x_userList = getMassFolwUserListDistinct($db_UF_Limit);
for ($k = 0; $k < count($x_userList); $k++) 
{	
 // echo '<br/> limit'.($db_UF_Limit-$x_count);
  $userList = getMassFolwUserList($x_userList[$k]['followfrom'],$db_UF_Limit);
  $x_count= count($userList);
  $twitterFollowOverFlag = false;
  for ($i = 0; $i < count($userList); $i++) 
  {	
	echo '<br/>-------------------------------------------------------------------------------------------';
	echo '<br/>'.$userList[$i]['followfrom'];
	$followedCount = dkGetUserFollowCount($userList[$i]['UserID']);
	$followLimit   = dkGetCommonSettings('follow_user_limt');
	if($followedCount>=$followLimit) continue;
	//$dkRateLimit = 0;
	//validation using Keys
	$followFriend = new SearchFollowAPI($userList[$i]['key'], $userList[$i]['secretkey']);
	//echo '<br/> Ratelimit:'.$dkRateLimit =$followFriend->dkratelimitskey();
	//if($dkRateLimit<$uPRateLimit) continue;
	$followed=$followFriend->followUser($userList[$i]['followto']);
			$rTemp = get_object_vars($followed);
			$dkFindTemp = 'You are unable to follow more people at this time';
			if(strpos($rTemp['error'],$dkFindTemp))
			{
				echo '<br/> Twitter Error: '.$dkFindTemp.'<br/> Exit 1';
				$twitterFollowOverFlag = true;
				break;
			}
		 echo ' Following   ';
		 echo $userList[$i]['followto'];
		 dkLogMassFollowedUser($userList[$i]['UserID'],$userList[$i]['followfrom'],$userList[$i]['followto']);
		 addapistatinfo1("cronMassFollow","friendships/create",$userName, $dt); 
		 clearMassFolwUser($userList[$i]['followfrom'],$userList[$i]['followto']);
		 if($twitterFollowOverFlag)
		{
			echo ' | Exit 2';
			$twitterFollowOverFlag = false;
			break;
		}
	}
}	
?>
