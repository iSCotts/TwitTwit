<?php
/*
 * File:	crongroupfollow.php
 *
 */
include ('../searchFollow/cronClasses.php');
include_once ('../searchFollow/cronCommon.php');
//following newly joined member to other group members

//$sql="SELECT gf.groupID,gf.userfollow,gf.userTofollow,uk.Username,uk.key,uk.secretkey,uk.type FROM ta_group_follow as gf, ta_user_keys as uk
//WHERE gf.userfollow = uk.Username limit 0,5";
 $sql="SELECT gf.groupID,gf.userfollow,gf.userTofollow,uk.Username,uk.key,uk.secretkey,uk.type,u.`UserID` FROM ta_group_follow gf LEFT JOIN  ta_users u ON gf.`userfollow`=u.`UserName` LEFT JOIN   ta_user_keys uk ON gf.`userfollow`=u.`UserName` WHERE gf.userfollow = uk.Username limit 0,5";
$db = Mysql :: getInstance();
		$db->Open();
		$memberList = $db->FetchArray($db->Query($sql));
		$db->Close();
$membercount = count($memberList);
$dt = date('Y-m-d');
for ($i = 0; $i < $membercount; $i++) {
	$followedCount = dkGetUserFollowCount($memberList[$i]['UserID']);
	$followLimit   = dkGetCommonSettings('follow_user_limt');
	if($followedCount>=$followLimit) continue;
	dkLogMassFollowedUser($memberList[$i]['UserID'],$memberList[$i]['userfollow'],$memberList[$i]['userTofollow']);
	$followFriend = new SearchFollowAPI($memberList[$i]['key'], $memberList[$i]['secretkey']);
	if ($memberList[$i]['type'] == 'no') {
		/**
		 * validation using Keys
			*/
		$followFriend = new SearchFollowAPI($memberList[$i]['key'], $memberList[$i]['secretkey']);
	} else
		if ($memberList[$i]['type'] == 'yes') {
			/**
			 * validation normal
			 */
			$followFriend = new SearchFollow($memberList[$i]['userfollow'], $memberList[$i]['secretkey']);
		}
		$followed=$followFriend->followUser($memberList[$i]['userTofollow']);
	}

 $sql="SELECT gf.groupID,gf.userfollow,gf.userTofollow,uk.Username,uk.key,uk.secretkey,uk.type,u.`UserID` FROM ta_group_follow gf LEFT JOIN  ta_users u ON gf.`userTofollow`=u.`UserName` LEFT JOIN   ta_user_keys uk ON gf.`userTofollow`=u.`UserName` WHERE gf.userTofollow = uk.Username limit 0,5";
$db = Mysql :: getInstance();
		$db->Open();
		$memberList = $db->FetchArray($db->Query($sql));
		$db->Close();
 $membercount = count($memberList);
//----------------------------------------
for ($i = 0; $i < $membercount; $i++) {
	$followedCount = dkGetUserFollowCount($memberList[$i]['UserID']);
	$followLimit   = dkGetCommonSettings('follow_user_limt');
	if($followedCount>=$followLimit) continue;
	dkLogMassFollowedUser($memberList[$i]['UserID'],$memberList[$i]['userTofollow'],$memberList[$i]['userfollow']);
	$followFriend = new SearchFollowAPI($memberList[$i]['key'], $memberList[$i]['secretkey']);
	if ($memberList[$i]['type'] == 'no') {
		/**
		 * validation using Keys
			*/
		$followFriend = new SearchFollowAPI($memberList[$i]['key'], $memberList[$i]['secretkey']);
	} else
		if ($memberList[$i]['type'] == 'yes') {
			/**
			 * validation normal
			 */
			$followFriend = new SearchFollow($memberList[$i]['userTofollow'], $memberList[$i]['secretkey']);
		}
		$followed=$followFriend->followUser($memberList[$i]['userfollow']);
		$gid=$memberList[$i]['groupID'];
		$userfollow=$memberList[$i]['userfollow'];
		$usertofollow=$memberList[$i]['userTofollow'];
		//movetolog($gid,$userfollow,$usertofollow,$dt);
		$sqlinsert="insert into ta_group_follow_log(groupID,userfollow,userTofollow,DT)values('{$gid}','{$userfollow}','{$usertofollow}','{$dt}')";
		$db = Mysql :: getInstance();
		$db->Open();
		$executeResults = $db->Query($sqlinsert);
		$db->Close();
	
		$sql="delete from ta_group_follow where groupID='$gid' and userfollow='$userfollow' and userTofollow='$usertofollow'";
		$db = Mysql :: getInstance();
		$db->Open();
		$executeResults = $db->Query($sql);
		$db->Close();
		return $executeResults;
}
/*function movetolog($gid,$userfollow,$usertofollow,$dt)
{
	$sqlinsert="insert into ta_group_follow_log(groupID,userfollow,userTofollow,DT)values('{$gid}','{$userfollow}','{$usertofollow}','{$dt}')";
	$db = Mysql :: getInstance();
	$db->Open();
	$executeResults = $db->Query($sqlinsert);
	$db->Close();

	$sql="delete from ta_group_follow where groupID='$gid' and userfollow='$userfollow' and userTofollow='$usertofollow'";
	$db = Mysql :: getInstance();
	$db->Open();
	$executeResults = $db->Query($sql);
	$db->Close();
	return $executeResults;
	}
*/	
?>
