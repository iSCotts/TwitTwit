<?php
/*
 * Created on 18-March-2010
 * Author :	Divya
 * File:	crongroupfollow.php
 *
 */
include ('cronClasses.php');
//following newly joined member to other group members

$sql="SELECT gf.groupID,gf.userfollow,gf.userTofollow,uk.Username,uk.key,uk.secretkey,uk.type FROM ta_group_follow as gf, ta_user_keys as uk
WHERE gf.userfollow = uk.Username limit 0,5";
$db = Mysql :: getInstance();
		$db->Open();
		$memberList = $db->FetchArray($db->Query($sql));
		$db->Close();
$membercount = count($memberList);
$dt = date('Y-m-d');
for ($i = 0; $i < $membercount; $i++) {
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


//----------------------------------------
for ($i = 0; $i < $membercount; $i++) {
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
		movetolog($gid,$userfollow,$usertofollow,$dt);
}
function movetolog($gid,$userfollow,$usertofollow,$dt)
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
?>
