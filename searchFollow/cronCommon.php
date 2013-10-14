<?php
/*
 * Created on 30-Jan-2010
 * Author :	liju
 * File:	cronFollowUsers.php
 *
 */
include_once('../config/config.php');
include_once('../classes/Database.php');
include_once('../classes/Mysql.php');
include_once('../classes/twitteroauth.php');
include_once('../classes/class.twitter.php');
function keyWordUsers($user,$keyID){
	$limit = ' LIMIT 0,10 ';
	$limit_diff = dkGetCommonSettings('follow_user_per_keyword_limt');
	if(intval($limit_diff)) $limit = " LIMIT 0,$limit_diff ";
	$sql="select KM.from_user,KM.id as MessageID,KU.CampaignID
		from ta_users U
		inner join ta_keyword_users KU using (UserID)
		inner join ta_keyword_message KM using (keyId)
		inner join ta_keyword K using (KeyId)
		inner join ta_campaigns C ON C.CampaignID=KU.CampaignID
		where  C.Status='A'  AND KeywordStatus='A' AND U.UserID={$user}
        AND KU.Followers< KU.FollowCount AND KU.keyId={$keyID} AND KM.id NOT IN (
			select keywordMessageId from ta_keyword_follow KF
			inner join ta_keyword_message KM on KM.id=KF.keywordMessageId
		)
		AND KM.id NOT IN(SELECT `id` FROM `ta_user_followed_keyword_users` WHERE `user_id` = '$user')
 		group by KM.from_user order by KM.created_at DESC $limit ";

		$db = Mysql :: getInstance();
		$db->Open();
		$queryResults = $db->FetchArray($db->Query($sql));
		$db->Close();
		return $queryResults;

}
function keyWordFollowList($user,$keyID){
	 $sql="select KM.from_user from ta_keyword_users  KU
		inner join ta_campaigns C using(CampaignID)
		inner join ta_keyword_follow KF using(keyId)
		inner join ta_keyword_message KM using(keyId)
		where KM.id=KF.keywordMessageId AND C.Status='A' AND KeywordStatus='A'
   			AND KU.UserId={$user} AND KU.keyId={$keyID}
		order By created_at";

		$db = Mysql :: getInstance();
		$db->Open();
		$queryResults = $db->FetchArray($db->Query($sql));
		$db->Close();
		return $queryResults;

}
function dkGetUserId($username)
{
	$sql=" SELECT `UserID` FROM `ta_users` WHERE `UserName` ='$username' ";
	$db = Mysql :: getInstance();
	$db->Open();
	$queryResults = $db->FetchArray($db->Query($sql));
	$db->Close();
	if(count($queryResults) == 0) return 0;
	else return $queryResults[0]['UserID'];
}
function getkeyWordList($user){
	  $sql="select KU.*,U.* from ta_keyword_users KU
	  		inner join ta_users U using (UserID)
	  		inner join ta_campaigns C using (CampaignID)
	  		where  C.Status='A'  AND KeywordStatus='A' AND
	  		 KU.UserID={$user}";
		$db = Mysql :: getInstance();
		$db->Open();
		$queryResults = $db->FetchArray($db->Query($sql));
		$db->Close();
		return $queryResults;

}
function dkGetUserFollowCount($user_id = 0)
{
	if($user_id==0) return 0;
	else
	{
		$sql="SELECT COUNT(*) AS cnt FROM `ta_user_followed_keyword_users` WHERE `user_id` = '$user_id' AND DATE_FORMAT(`followed_date_time`, '%Y-%m-%d') = '".date('Y-m-d')."'";
		$db = Mysql :: getInstance();
		$db->Open();
		$queryResults = $db->FetchArray($db->Query($sql));
		$db->Close();
		return $queryResults[0]['cnt'];
	}
}
function dkGetCommonSettings($title='')
{
	if($title=='') return 0;
	else
	{
	  	$sql="SELECT `value` FROM `ta_common_settings` WHERE `title` = '$title'";
		$db = Mysql :: getInstance();
		$db->Open();
		$queryResults = $db->FetchArray($db->Query($sql));
		$db->Close();
		if(count($queryResults) == 0) return 0;
		else return $queryResults[0]['value'];
	}
}
function dkLogFollowedUser($user_id,$id)
{
		$db = Mysql :: getInstance();
		$db->Open();
		$sql="INSERT INTO `ta_user_followed_keyword_users` ( `user_id`,`id`) VALUES ('$user_id','$id')";
		$db->Query($sql);
		$db->Close();
}
function getUserList(){
	$db = Mysql :: getInstance();
	$db->Open();
    $query = "SELECT `limit_start`, `limit_diff` FROM `ta_follow_user_cron_buffer`";
	$x = $db->FetchArray($db->Query($query));
	if(count($x)>0)
	{
		$limit = 'LIMIT '.$x[0]['limit_start'].','.$x[0]['limit_diff'];
	}
	else
	{
		$limit = '';
	}
	$sql="select U.UserID,UK.Username,UK.key,UK.secretkey,UK.type from ta_users U
		inner join ta_user_keys UK using (UserName)
		inner join ta_keyword_users KU using (UserId)
		inner join ta_campaigns C ON C.CampaignID=KU.CampaignID
		where C.Status='A' group by UK.Username ";
	$queryResults = $db->FetchArray($db->Query($sql.$limit));
	if(count($queryResults)>0)
	{
		$query = "UPDATE `ta_follow_user_cron_buffer` SET `limit_start` = `limit_start`+limit_diff ";
	}
	else
	{
		$query = "UPDATE `ta_follow_user_cron_buffer` SET `limit_start` = limit_diff ";
		if(count($x)>0)
		{
			$limit = 'LIMIT 0 ,'.$x[0]['limit_diff'];
		}
		else
		{
			$limit = '';
		}
		$queryResults = $db->FetchArray($db->Query($sql.$limit));
	}
	$db->Query($query);
	$db->Close();
	return $queryResults;
}
/**
 * saving friends
 */
 function saveFollowers($keywordMessageId,$KeywordUserID,$KeyID){
 	$sql= "insert into ta_keyword_follow (keywordMessageId,KeywordUserID,KeyID) values ({$keywordMessageId},{$KeywordUserID},{$KeyID})";
 	$db = Mysql :: getInstance();
		$db->Open();
		$queryResults = $db->Query($sql);
		$db->Close();
 }
function multi2dSortAsc(& $arr, $key) {
	$sort_col = array ();
	foreach ($arr as $sub)
		$sort_col[] = $sub[$key];
	array_multisort($sort_col, $arr);
}

/**
 * copy one array to another
 *
 */
function setToArray($results, & $keywordMessages) {
	$resultCount = count($results);
	for ($i = 0; $i < $resultCount; $i++) {
		$result = $results[$i];
		$keywordMessage['profile_image_url'] = $result[profile_image_url];
		$keywordMessage['from_user'] = $result[from_user];
		$keywordMessage['created_at'] = strtotime($result[created_at]);
		$keywordMessage['profile_image_url'] = $result[profile_image_url];
		$keywordMessage['text'] = $result[text];
		array_push($keywordMessages, $keywordMessage);
	}
}
function addkeywordMessage($request, $id) {
	$phpdate = date('Y-m-d H:i:s');
	echo $phpdate;
	echo $sql = "select created_at from ta_keyword_message where keyId={$id} order by created_at desc ";
	$db = Mysql :: getInstance();
	$db->Open();
	$result = $db->FetchArray($db->Query($sql));
	if ($result[0][0] < $request['created_at']) {
		$imageUrl = urlencode($request['profile_image_url']);
		$text = addslashes($request['text']);
		$sql = "insert into ta_keyword_message(keyId,profile_image_url,text,from_user,created_at,DT)" . "values($id,'{$imageUrl}','{$text}','{$request['from_user']}',{$request['created_at']},'{$phpdate}')";
		$db->Query($sql);
	}
	$db->Close();
}
/**
 * update follow count in keyword users table
 */
function setKeywordfollowersForUser($campainId, $keyword, $userid) {
	$sql = "SELECT count(*) as followers  FROM ta_keyword_follow KF
		inner join ta_users U on KF.KeywordUserID=U.UserId
		inner join ta_keyword K on K.KeyID =KF.KeyID
		where  U.UserId={$userid} AND K.KeyId={$keyword}";
	$db = Mysql :: getInstance();
	$db->Open();
	$followcount = $db->FetchArray($db->Query($sql));

	$sql = "update ta_keyword_users set Followers={$followcount[0]['followers']}
				where UserId={$userid} and CampaignID={$campainId} and keyId={$keyword};";
	 $db->Query($sql);
}
function addapistatinfo1($appln,$api,$user,$dt) {
	$sql = "insert into ta_api_statistics(application,apitype,username,DT) values ('{$appln}','{$api}','{$user}','{$dt}');";
	$db = Mysql :: getInstance();
	$db->Open();
	$queryResults = $db->Query($sql);
	$db->Close();
}
function selectfollowcount($userid,$kuid)
{
	$query="SELECT COUNT(*) AS cnt FROM `ta_user_followed_keyword_users` WHERE `user_id`='$userid' AND `id` = '$kuid'";
	$db = Mysql :: getInstance();
	$db->Open();
	$result = $db->FetchArray($db->Query($query));
	$db->Close();
	return $result[0]['cnt'];
}
function getQueuedUserListDistinct(){
	$db = Mysql :: getInstance();
	$db->Open();
    $query = "SELECT DISTINCT user_name FROM ta_follow_queued_user_list LIMIT 0,5";
	$result = $db->FetchArray($db->Query($query));
	$db->Close();
	return $result;
}
function getMassFolwUserListDistinct($endlimit){
    $db = Mysql :: getInstance();
	$db->Open();
    $query = "SELECT `limit_start` FROM `ta_mass_follow_cron_buffer`";
	$x = $db->FetchArray($db->Query($query));
	if(count($x)>0)
	{
		$limit = 'LIMIT '.$x[0]['limit_start'].','.$endlimit;
	}
	else
	{
		$limit = '';
	}
	$sql = "SELECT DISTINCT followfrom FROM ta_mass_follow ";
	$queryResults = $db->FetchArray($db->Query($sql.$limit));
	if(count($queryResults)>0)
	{
		  $query = "UPDATE `ta_mass_follow_cron_buffer` SET `limit_start` = `limit_start`+'$endlimit' ";
	}
	else
	{
		$query = "UPDATE `ta_mass_follow_cron_buffer` SET `limit_start` ='$endlimit'";
		if(count($x)>0)
		{
			 $limit = 'LIMIT 0 ,'.$endlimit;
		}
		else
		{
			$limit = '';
		}
		$queryResults = $db->FetchArray($db->Query($sql.$limit));
	}
	$db->Query($query);
	$db->Close();
	return $queryResults;
}

function getQueuedUserList($user_name='',$limit=5){
	$db = Mysql :: getInstance();
	$db->Open();
    $query = "SELECT U.UserID,FQ.user_name,FQ.follow_user_name,FQ.key_id,FQ.profile_image_url,FQ.text,UK.key,UK.secretkey,UK.type FROM ta_follow_queued_user_list FQ LEFT JOIN  ta_users U
		ON U.Username=FQ.user_name 	LEFT JOIN ta_user_keys UK ON UK.Username=FQ.user_name WHERE FQ.user_name = '$user_name' GROUP BY FQ.key_id,FQ.user_name LIMIT 0,$limit";
	$result = $db->FetchArray($db->Query($query));
	$db->Close();
	return $result;
}
function getMassFolwUserList($user_name='',$limit=5){
	$db = Mysql :: getInstance();
	$db->Open();
	$query = "SELECT U.UserID, MF.followfrom, MF.followto, UK.key, UK.secretkey, UK.type FROM ta_mass_follow MF LEFT JOIN  ta_users U
		ON U.Username=MF.followfrom LEFT JOIN ta_user_keys UK ON UK.Username=MF.followfrom WHERE MF.followfrom = '$user_name' LIMIT 0,$limit";
	$result = $db->FetchArray($db->Query($query));
	$db->Close();
	return $result;
}
function dkLogQueuedFollowedUser($user_id,$user_name,$followed_user_name,$keyid,$profile_image_url,$text)
{
		$db = Mysql :: getInstance();
		$db->Open();
		$text=addslashes($text);
		$sql="INSERT INTO `ta_user_followed_keyword_users` ( `user_id`,`user_name`,`follow_to`,`followed_user_name`,`key_id`,`profile_image_url`,`text`) VALUES ('$user_id','$user_name','$followed_user_name','$followed_user_name','$keyid','$profile_image_url','$text')";
		$db->Query($sql);
		$db->Close();
}
function dkLogMassFollowedUser($user_id,$user_name,$followed_user_name)
{
		$db = Mysql :: getInstance();
		$db->Open();
		$sql="INSERT INTO `ta_user_followed_keyword_users` (`user_id`,`follow_to`,`followed_user_name`) VALUES ('$user_id','$user_name','$followed_user_name')";
		$db->Query($sql);
		$db->Close();
}
function	 clearQueuedUser($username,$follow_user_name)
{
	$sql="DELETE  FROM `ta_follow_queued_user_list` WHERE 	user_name='$username' and follow_user_name='$follow_user_name'";
	$db = Mysql :: getInstance();
	$db->Open();
	$executeResults = $db->Query($sql);
	$db->Close();
	return $executeResults;
}
function	 clearMassFolwUser($username,$follow_user_name)
{
	$sql="DELETE  FROM `ta_mass_follow` WHERE  followfrom='$username' and followto='$follow_user_name'";
	$db = Mysql :: getInstance();
	$db->Open();
	$executeResults = $db->Query($sql);
	$db->Close();
	return $executeResults;
}
