<?php
/*
 * Created on 11-DEC-2009
 *
 * Created By Liju Mammen
 *
 * File Name sqlFunctions.php
 */
/**
 * COMMON NONDATABASE FUNCTION
 * ---------------------------
 */
include ('commonfunctions.php');
/**
 * COMMON FUNCTIONS
 * ----------------
 */
/**
 * Used to run a Query
 * @param $sql
 * @return list
 */
function runQuery($sql) {
	$db = Mysql :: getInstance();
	$db->Open();
	$queryResults = $db->FetchArray($db->Query($sql));
	$db->Close();
	return $queryResults;
}
/**
 * Common function for inserting or update sql statements
 * @param String $sql
 * @return integer value
 */
function executeQuery($sql) {
	$db = Mysql :: getInstance();
	$db->Open();
	$executeResults = $db->Query($sql);
	$db->Close();
	return $executeResults;
}

function insertQuery($sql) {
	$db = Mysql :: getInstance();
	$db->Open();
	$executeResults = $db->Query($sql);
	$id = $db->insertId();
	$db->Close();
	return $id;
}

function lgxLastInsertedId() {
	$db = Mysql :: getInstance();
	$db->Open();
	$id = $db->insertId();
	$db->Close();
	return $id;
}
/**
 * FUNCTIONS TO GET  FROM DATABASE
 * --------------------------
 */
/*function dkGenerateUrl($numAlpha=6)
{
   $listAlpha = 'abcdefghijklmnopqrstuvwxyz0123456789';
   return str_shuffle(substr(str_shuffle($listAlpha),0,$numAlpha));
}
function dkGetUrl($in='',$campaignID = '',$appType = '',$comId = '')
{
   do
   {
		 $out 		= generateurl();
		 $query 	= "SELECT short  FROM `ta_short_urls` WHERE `short` = '$out'";
		 $result 	= runQuery($query);
   } while (count($result) >1);
   $insert_query = " INSERT INTO `ta_short_urls` ( `id` , `campaign_id` , `app_type` , `com_id` , `short` , `url` , `stamped` , `mc` )"
				  . " VALUES ( NULL , '$campaignID', '$appType', '$comId', '$out', '$in', NOW(), '0' ) ";
   executeQuery($insert_query);
   return "http://twitjix.com/".$out;
}
function dkCreatStringWithShortUrls($campaignID = '',$appType = '',$comId = '',$text = '') 
{
	if(intval($campaignID) && !empty($appType)  && intval($comId) && !empty($text))
	{
		$dkTemp 	= explode(' ',$text);
		$text		= '';
		for($i=0;$i<count($dkTemp);$i++)
		{
			$flagA  	= filter_var($dkTemp[$i], FILTER_VALIDATE_URL);
			$flagB  	= filter_var('http://'.$dkTemp[$i], FILTER_VALIDATE_URL);
			$flagB  	= filter_var('https://'.$dkTemp[$i], FILTER_VALIDATE_URL);
			if($flagA || $flagB || $flagB)
			{
				$text.= ' '.dkGetUrl($dkTemp[$i],$campaignID,$appType,$comId);
			}
			else
			{
				$text.= ' '.$dkTemp[$i];
			}
		}
	}
	return $text;
}
*/
function dkGetKeyword($key_id)
{
	$query="SELECT `Message` FROM `ta_keyword` WHERE `KeyID` = '$key_id' ";
	$result = runQuery($query);
	if(count($result)>0)
	{
		return $result[0]['Message'];
	}
	else
	{
		return '';
	}
}
function dkGetCommonSettings($title = "") 
{
	$value = '';
	$query = " SELECT `value` FROM `ta_common_settings` WHERE `title` = '$title' ";
	$temp  = runQuery($query);
	if(count($temp)>0)
	{
		$value = $temp[0]['value'];
	}
	return $value;
}
function dkGetBlockUserListCount($user_name = "",$key_id = "") 
{
	$query = " SELECT COUNT(*) AS cnt FROM  `ta_follow_blocked_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ";
	$temp  = runQuery($query);
	return $temp[0]['cnt'];
}
function dkGetSuggestionsUserListCount($user_name = "",$key_id = "") 
{
	$query = "SELECT COUNT(DISTINCT from_user) AS cnt FROM `ta_keyword_message` "
		   . " WHERE `keyId` = '$key_id' "
		   . " AND `from_user` NOT IN (SELECT `blocked` FROM `ta_follow_blocked_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ) "
		   . " AND `from_user` NOT IN (SELECT `follow_user_name` FROM `ta_follow_queued_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ) "
		   . " AND `from_user` NOT IN (SELECT `followed_user_name` FROM `ta_user_followed_keyword_users` WHERE `user_name` = '$user_name' ) ";
		   
		   
		   
//-------------------- new query---------------------	   
$fromUser = array();
$in		  = '';
$query = "SELECT DISTINCT `blocked` FROM `ta_follow_blocked_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ";
$temp  = runQuery($query);
for($i=0;$i<count($temp);$i++)
{
	if(empty($in))
	{
		$in.= "'".$temp[$i]['blocked']."'";
	}
	else
	{
		$in.= ", '".$temp[$i]['blocked']."'";
	}
	$fromUser[] = $temp[$i]['blocked'];
}
unset($temp);
$query = "SELECT DISTINCT `follow_user_name` FROM `ta_follow_queued_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id'";
$temp  = runQuery($query);
for($i=0;$i<count($temp);$i++)
{
	if(!in_array($temp[$i]['follow_user_name'],$fromUser))
	{
		if(empty($in))
		{
			$in.= "'".$temp[$i]['follow_user_name']."'";
		}
		else
		{
			$in.= ", '".$temp[$i]['follow_user_name']."'";
		}
		$fromUser[] = $temp[$i]['follow_user_name'];
	}
}
unset($temp);
$query = "SELECT DISTINCT `followed_user_name` FROM `ta_user_followed_keyword_users` WHERE `user_name` = '$user_name' ";
$temp  = runQuery($query);
for($i=0;$i<count($temp);$i++)
{
	if(!in_array($temp[$i]['followed_user_name'],$fromUser))
	{
		if(empty($in))
		{
			$in.= "'".$temp[$i]['followed_user_name']."'";
		}
		else
		{
			$in.= ", '".$temp[$i]['followed_user_name']."'";
		}
		$fromUser[] = $temp[$i]['followed_user_name'];
	}
}
unset($temp);
unset($fromUser);
if(empty($in))
{
$query = "SELECT COUNT(DISTINCT from_user) AS cnt FROM `ta_keyword_message` WHERE `keyId` = '$key_id'";
}
else
{
$query = "SELECT COUNT(DISTINCT from_user) AS cnt FROM `ta_keyword_message` WHERE `keyId` = '$key_id'  AND `from_user` NOT IN ($in)";
}
//-------------------- new query---------------------	   
		   
		   
	$temp  = runQuery($query);
	$xcount = selectkeywordfollowcount($user_name,$key_id);
	$xcountTemp = dkGetBlockUserListCount($user_name,$key_id)+dkGetQueuedUserListCount($user_name,$key_id)+dkGetFollowedUserListCount($user_name,$key_id); 
	if(intval($xcount))
	{
		if($xcountTemp >= $xcount) 
		{
			return 0;
		}
		else
		{
			$xcount-=$xcountTemp;
			if($xcount>=$temp[0]['cnt'])
			{
				return $temp[0]['cnt'];
			}
			else
			{
				return $xcount;
			}
		}
	}
	else
	{
		return $temp[0]['cnt'];
	}
}
function dkGetQueuedUserListCount($user_name = "",$key_id = "") 
{
	$query = " SELECT COUNT(*) AS cnt FROM  `ta_follow_queued_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ";
	$temp  = runQuery($query);
	return $temp[0]['cnt'];
}
function dkGetFollowedUserListCount($user_name = "",$key_id = "") 
{
	$query = " SELECT COUNT(*) AS cnt FROM  `ta_user_followed_keyword_users` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ";
	$temp  = runQuery($query);
	return $temp[0]['cnt'];
}
function dkGetNoCampaignFeeds($CampaignID = "") 
{
	$campaignFeeds	= 0;
	if(!empty($CampaignID)) 
	{
		$query = " SELECT COUNT(*) AS cnt FROM  `ta_feeds` WHERE `CampaignID` = '$CampaignID' ";
		$temp  = runQuery($query);
		$campaignFeeds 	= $temp[0]['cnt'];
	}
	return $campaignFeeds;
}
function dkGetNoCampaignKeywords($CampaignID = "") 
{
	$campaignKeywords	= 0;
	if(!empty($CampaignID)) 
	{
		$query = " SELECT COUNT(*) AS cnt FROM  `ta_keyword_users` WHERE `CampaignID` = '$CampaignID' ";
		$temp  = runQuery($query);
		$campaignKeywords 	= $temp[0]['cnt'];
	}
	return $campaignKeywords;
}
function dkGetNoAddons($refuser = "") 
{
	$addOnUser	= 0;
	if(!empty($refuser)) 
	{
		$query = " SELECT COUNT(*) AS cnt FROM  `ta_users` WHERE `RefID` = '$refuser' ";
		$temp  = runQuery($query);
		$addOnUser 	= $temp[0]['cnt'];
	}
	return $addOnUser;
}

function dkGetNoCampaign($userName = "") 
{
	$campaign	= 0;
	if(!empty($userName)) 
	{
		$query = " SELECT COUNT(*) AS cnt FROM `ta_campaigns` WHERE `RefID` IN (SELECT `RefID` FROM `ta_users` WHERE `UserName` = '$userName') ";
		$temp  = runQuery($query);
		$campaign 	= $temp[0]['cnt'];
	}
	return $campaign;
}
function dkGetPackagedetails($userName = "") 
{
	$package['campaignLimit'] 	= 0;
	$package['keywordLimit'] 	= 0;	
	$package['feedLimit'] 		= 0;
	$package['followLimit'] 	= 0;	
	$package['twitterAcc'] 	= 0;	
	if(!empty($userName)) 
	{
		$query = "SELECT `campaignLimit`, `keywordLimit`, `rssFeeds`,`followLimit`,`twitterAcc` FROM `ta_packages` a"
			   . " LEFT JOIN `ta_user_subscriptions` b ON a.`PackageID` = b.`PackageID`"
			   . " WHERE b.`UserName`='$userName'";
		$temp  = runQuery($query);
		if(count($temp)>0)
		{
			$package['campaignLimit'] 	= $temp[0]['campaignLimit'];
			$package['keywordLimit'] 	= $temp[0]['keywordLimit'];	
			$package['feedLimit'] 		= $temp[0]['rssFeeds'];	
			$package['followLimit'] 	= $temp[0]['followLimit'];	
			$package['twitterAcc'] 	= $temp[0]['twitterAcc'];	
			}
	}
	return $package;
}
/**
 * gets package details for the specific package
 * system
 * @param $username
 * @param $password
 * @return Number of rows
 */
function getPackagedetails($package = "") {
	if ($package == "") {
		$sql = "SELECT *FROM `ta_packages`";
	} else {
		$sql = "SELECT *FROM `ta_packages` WHERE PackageID ='{$package}'";
	}
	return runQuery($sql);
}
/**
 * Admin User/password e
 * system
 * @param $username
 * @param $password
 * @return Number of rows
 */
function getAdminLogin($username, $password) {
	$sql = "SELECT * FROM ta_admin_users WHERE username ='{$username}' && password = '{$password}'  && status='Active'";
	$db = Mysql :: getInstance();
	$db->Open();
	$loginDetails = $db->NumRows($db->Query($sql));
	$db->Close();
	return $loginDetails;
}
/**
 * get MailTemplate details
 *
 * @param $username
 * @param $password
 * @return staffid
 */
function getMailTemplate($id = "") {
	if ($id == "") {
		$sql = "SELECT * from mailTemplate";
	} else {
		$sql = "SELECT * from mailTemplate where id='{$id}'";
	}
	return runQuery($sql);
}
/**
 * get MailTemplate details
 *
 * @param $name
 * @return UserSubscriptions
 */
function getSubscriptionDetails($name) {
	$sql = "select * from ta_user_subscriptions where UserName='{$name}'";
	return runQuery($sql);
}
/**
 * get User Id
 */
function getUserId($name) {
	$sql = "select UserID,RefID from ta_users where UserName='{$name}' order by UserName DESC";
	return runQuery($sql);
}
function getAutoTextUserName($userid, $string, $campaignID) {
	$sql = "SELECT KM.from_user FROM ta_keyword_users KU
			inner join ta_keyword K using (KeyID)
			inner join ta_users U using (UserID)
			inner join ta_keyword_message  KM using (KeyID)
			inner join ta_keyword_follow KF using(KeyId)
			where U.UserID={$userid} and KU.CampaignID={$campaignID} AND  KF.keywordMessageId=KM.id AND KM.from_user like '{$string}%'
			group by KM.from_user order by KM.from_user"; /*
	"SELECT KM.from_user FROM ta_keyword_message KM
			inner join ta_keyword_users KU using (keyId)
			inner join ta_users U using (UserID)
			inner join ta_keyword_follow KF on KF.keywordMessageId=KM.id
			where U.UserID={$userid} AND KU.CampaignID={$campaignID} AND KM.from_user like '{$string}%' group by KM.from_user order by KM.from_user";
	*/
	return runQuery($sql);
}
function getUserName($id) {
	$sql = "select UserName from ta_users where UserID='{$id}'";
	return runQuery($sql);
}
function getUserPASSId($name) {
	$sql = "select U.RefID,UK.*,U.UserID from ta_user_keys UK inner join ta_users U on U.UserName=UK.Username where UK.Username='{$name}'";
	return runQuery($sql);
}
/**
 * getting number of used keywords and total number of keywords
 */
function getkeywordLimit($name) {
	$sql = "SELECT P.keywordLimit,
			(select count(*) from ta_keyword_users WHERE U.UserName='{$name}')as usedLimit
			FROM ta_users U
			inner join ta_packages P on P.packageID=U.refId
			WHERE U.UserName='{$name}'";
	return runQuery($sql);
}
/**
 * get Feeds
 */
function getFeeds() {
	$sql = "select * from ta_feeds ";
	return runQuery($sql);
}
/**
 * gets users keyword from table
 */
function getKeywordSearchForUser($campainId, $userName) {
	$sql = "SELECT  K.KeyId,K.Message,KU.* FROM ta_users U
					inner join ta_keyword_users KU using (UserId)
					inner join ta_keyword K using (KeyId)
					where  KU.CampaignID={$campainId} and U.UserName='{$userName}' ORDER BY K.Message ASC";
	return runQuery($sql);
}
/**
 * get keywords for the specified ID
 * @return array(KeyId, Keyword and  KeywordUsers table Details)
 */
function getKeywordSearchForKeyId($id) {
	$sql = "SELECT  K.KeyId,K.Message,KU.* FROM ta_users U inner join ta_keyword_users KU using (UserId)  inner join ta_keyword K using (KeyId) where K.KeyId='{$id}'";
	return runQuery($sql);
}
/**
 * find whether message is there
 * @var $messageid keyid
 * @var $lang language
 */
function getkeyword($messageid = false,$lang=false) {
    $query = "SELECT `limit_start`, `limit_diff` FROM `ta_keyword_search_cron_buffer`";
	$x = runQuery($query);
	if(count($x)>0)
	{
		$limit = 'LIMIT '.$x[0]['limit_start'].','.$x[0]['limit_diff'];
	}
	else
	{
		$limit = '';
	}
	if ($messageid) {
		$sql="";
		if($lang){
			$sql=" AND K.lang='{$lang}'";
		}
		$sql = "SELECT K.KeyId,K.Message,K.since_id, K.max_id  FROM ta_keyword K
						WHERE K.KeyID='{$messageid}' {$sql} ";
	} else {
		$sql = "SELECT K.KeyId, K.Message,KU.Lang, K.since_id, K.max_id FROM ta_keyword_users KU
					inner join ta_keyword K using (keyId)
					inner join ta_campaigns C using (CampaignID)
					where C.Status='A' AND  (KU.FollowCount>(SELECT count( * ) FROM ta_keyword_users KU INNER JOIN ta_user_followed_keyword_users kfu ON KU.id = kfu.key_id) OR KU.FollowCount=1 ) AND KeywordStatus='A' group by  K.KeyId ";
					
	
	}
	$keys = runQuery($sql.$limit);
	if(count($keys)>0)
	{
		$query = "UPDATE `ta_keyword_search_cron_buffer` SET `limit_start` = `limit_start`+limit_diff ";
	}
	else
	{
		$query = "UPDATE `ta_keyword_search_cron_buffer` SET `limit_start` = limit_diff ";
		if(count($x)>0)
		{
			$limit = 'LIMIT 0 ,'.$x[0]['limit_diff'];
		}
		else
		{
			$limit = '';
		}
		$keys = runQuery($sql.$limit);
	}
	runQuery($query);
	return $keys;
}

function getkeywordMessage($keyId) {
	$sql = "SELECT * FROM ta_keyword_message  WHERE keyId='{$keyId}'";
	return runQuery($sql);
}
function getAllKeywordMessage($date = '', $count) {
	$sql = "SELECT KM.* FROM ta_keyword_message KM " . "left join ta_keyword_users KU using (KeyId) inner join ta_keyword K using (KeyId) ";
	if ($date != '')
		$sql .= $date;
	if($count==1)
	{
	$sql .= " order by  DT DESC , created_at DESC";
	}
	else{
	$sql .= " order by  DT DESC , created_at DESC LIMIT {$count}";
	}
	return runQuery($sql);
}
function getKeywordUser($campainID, $keyword) {
	$sql = "SELECT K.* FROM ta_keyword_users K
			INNER JOIN ta_users U USING ( UserId )
			WHERE K.CampaignID = '{$campainID}' AND  K.keyId={$keyword}";
		return runQuery($sql);
}
/**
 * get keyword User
 * @var campaignid
 * @var name username
 * @var $message keywordID
 */
function getKeywordUsers($campainID, $name, $message) {
	$sql = "SELECT K.* FROM ta_keyword_users K
					INNER JOIN ta_users U USING ( UserId )
					INNER JOIN ta_keyword Ky on Ky.KeyID=K.keyId
					WHERE K.CampaignID = '{$campainID}' AND  Ky.KeyID='{$message}' AND  U.UserName='{$name}'";
		return runQuery($sql);
}
function getCampaignDetails($username) {
	$sql = "SELECT * FROM ta_campaigns C
			inner join ta_users U using (RefID)
			where username='{$username}'
			group by C.CampaignName
			order by C.CampaignName";
	return runQuery($sql);
}
function getKeyWordMessages($KeywordId, $count,$type) {
	if($type=='follow'){
		$order='ASC';
	}
	else{
		$order='DESC';
	}
	$sql = "SELECT * FROM ta_keyword_message KM WHERE KM.keyId = {$KeywordId}  ORDER BY DT DESC , created_at DESC LIMIT 1,{$count}";
	return runQuery($sql);
}
/**
 * Gets Campaign details
 * @var $campainID campaignID
 */
function getCampaignUser($campainID) {
	$sql = "SELECT * FROM ta_campaigns  WHERE CampaignID = {$campainID}";
	return runQuery($sql);
}
/**
 *
 * FUNCTIONS TO ADD/UPDATE RECORDS TO DATABASE
 * -------------------------------------------
 */
/**
 * This function is used to save a new template into the database
 *
 * @param varchar $name
 * @param varchar $subject
 * @param text  $content
 * @return unknown|Insert into database
 */
function setNewMailTemplate($name, $subject, $content) {
	$name = htmlentities($name, ENT_QUOTES);
	$subject = htmlentities($subject, ENT_QUOTES);
	$content = htmlentities($content, ENT_QUOTES);
	$sql = "insert into mailTemplate (name,subject,content) values ('{$name}','{$subject}','{$content}');";
	return executeQuery($sql);
}
/**
 * update follow count in keyword users table
 * @var $campain ID
 * @var $keywordID
 * @var $user ID
 */
function setKeywordfollowersForUserkeyword($campainId, $keyword, $userid) {
	$sql = "SELECT  count(*) as followers FROM ta_keyword_follow KF
			inner join ta_keyword_users KU using (keyId)
			where  KU.CampaignID={$campainId} AND KF.KeyID={$keyword}";
	$followcount = runQuery($sql);
	$sql = "update ta_keyword_users set Followers={$followcount[0]['followers']}
			where UserId={$userid} and CampaignID={$campainId} and keyId={$keyword};";
	return executeQuery($sql);
}
/**
 * This function is used to save a new template into the database
 *
 * @param varchar $name
 * @param varchar $subject
 * @param text  $content
 * @return unknown|Insert into database
 */
function addNewPaypalIpn($paypal) {
	foreach ($paypal as $key => $value) {
		$insert[$key] = $value;
	}
	$phpdate = date('Y-m-d H:i:s');
	$sql = "insert into ta_paypal_subscription_payments
				(txn_type,residence_country,subscr_id,last_name,option_selection1,payment_gross,mc_currency,item_name,business,
				verify_sign,payer_status,test_ipn,	payer_email,first_name,receiver_email,payer_id,option_name1,
				retry_at,password,btn_id,mc_gross,username,notify_version,	creation_timestamp)
				values('{$insert['txn_type']}','{$insert['residence_country']}','{$insert['subscr_id']}',
				'{$insert['last_name']}','{$insert['option_selection1']}','{$insert['payment_gross']}',
				'{$insert['mc_currency']}','{$insert['item_name']}','{$insert['business']}',
				'{$insert['verify_sign']}','{$insert['payer_status']}','{$insert['test_ipn']}',
				'{$insert['payer_email']}','{$insert['first_name']}','{$insert['receiver_email']}',
				'{$insert['payer_id']}','{$insert['option_name1']}',
				'{$insert['retry_at']}','{$insert['password']}','{$insert['btn_id']}',
				'{$insert['mc_gross']}','{$insert['username']}','{$insert['notify_version']}',	'{$phpdate}'	)";
	return executeQuery($sql);
}
/**
 * This function is used to save a new template into the database
 *
 * @param varchar $request
 * @return Insert into database
 */
function addnewUser($name,$PackageID,$email='') {
	$field = "";
	;
	$parameter = "";
	$phpdate = date('Y-m-d H:i:s');
	if($email<>"")
	{
	$sql = "insert into ta_user_subscriptions(UserName,Email,PackageID,DT)values('{$name}','{$email}','{$PackageID}','{$phpdate}')";
		}
	else{
	$sql = "insert into ta_user_subscriptions(UserName,PackageID,DT)values('{$name}','{$PackageID}','{$phpdate}')";
	}
	return executeQuery($sql);
}
/**
 * Adds login user
 */
function addLoginUser($name, $password) {
	$subsId = getSubscriptionDetails($name);
	$sql = "select RefID from ta_users where RefID='{$subsId[0]['SubsID']}'";
	$refID = runQuery($sql);
	if ($refID[0][0] == 0 || $refID[0][0] == '') {
		$phpdate = date('Y-m-d H:i:s');
		$sql = "insert into ta_users(RefID,UserName,Password,DT)values('{$subsId[0]['SubsID']}','{$name}',password('{$password}'),'{$phpdate}')";
		return executeQuery($sql);
	}
}
/**
 * Adds a feed
 */
function addFeed($request) {
	$dkPackage 			= dkGetPackagedetails($request['username']);
	$dkNoCampaignFeeds	= dkGetNoCampaignFeeds($request['CampaignID']); 
	if($dkNoCampaignFeeds >= $dkPackage['feedLimit'])
	{
		return ' |brk|You have created '.$dkNoCampaignFeeds.' campaign feeds and your campaign feed limit is over.  <a href="upgrade">Please upgrade your account.</a>';
	}
	else
	{
	$userid = getUserId($request['username']);
	$phpdate = date('Y-m-d H:i:s');
	//if (isset ($_REQUEST[posturl]) && ($_REQUEST[posturl] == 1))
	//	$posturlstatus = 1;
	//else
	//	$posturlstatus = 0;
	//if (isset ($_REQUEST[shorturl]) && ($_REQUEST[shorturl] == 1))
	//	$shorturlstatus = 1;
	//else
	//	$shorturlstatus = 0;
	$posturlstatus = $_REQUEST[posturl];
	$shorturlstatus = $_REQUEST[shorturl];
	
	$checkfeedurlalreadythere = "SELECT count(*) FROM ta_feeds WHERE feedurl='{$request['feedurl']}' AND CampaignID='$_REQUEST[CampaignID]'";
	$checkfeedurlalreadythereresult = runQuery($checkfeedurlalreadythere);
	if ($checkfeedurlalreadythereresult[0][0] == 0) {
		$sql = "insert into ta_feeds(CampaignID,feedname,feedurl,sortid,isactive,posturl,shorturl,freq_id,showdesc,DT)values('$_REQUEST[CampaignID]','{$request['feedname']}','{$request['feedurl']}','{$request['sortid']}','1','$posturlstatus','$shorturlstatus','{$request['freq_id']}','{$request['showdesc']}','{$phpdate}')";
		executeQuery($sql);
		$html =  "<div class=green>The feed has been added</div>";
		$dkNoCampaignFeeds++;
		if($dkNoCampaignFeeds >= $dkPackage['feedLimit'])
		{
			$html.=  '|brk|You have created '.$dkNoCampaignFeeds.' campaign feeds and your campaign feed limit is over.  <a href="upgrade">Please upgrade your account.</a>';
		}
		return $html;
		
	} else {
		return "error(Feed Already Exists)";
	}
	}
	 
}
/**
 * Add a keyword into table
 */
function addkeyword($message, $lang='en') {
	$phpdate = date('Y-m-d H:i:s');
	$sql = "insert into ta_keyword(Message,lang,DT)values('{$message}','{$lang}','{$phpdate}')";
	$db = Mysql :: getInstance();
	$db->Open();
	$executeResults = $db->Query($sql);
	$idVal = $db->insertId();
	$db->Close();
	return $idVal;
}
function addkeywordnew($message, $lang='en') {
	$query = "select KeyID from ta_keyword where Message='{$message}'";
	$result = runQuery($query);
	if(count($result)>0)
	{
		$keycount=$result[0][0];
		return $keycount;
	}
	else
	{
	$phpdate = date('Y-m-d H:i:s');
	$sql = "insert into ta_keyword(Message,lang,DT)values('{$message}','{$lang}','{$phpdate}')";
	$db = Mysql :: getInstance();
	$db->Open();
	$executeResults = $db->Query($sql);
	$idVal = $db->insertId();
	$db->Close();
	return $idVal;
	}
}
/**
 * Adds all message relates to the keyword mentioned in keyword table
 * @var $request message Details in array
 * @var $id Keyword ID
 *
 */
function addkeywordMessage($request, $id) {
	$phpdate = date('Y-m-d');
	$sql = "select created_at from ta_keyword_message where keyId={$id} order by created_at desc ";
	$result = runQuery($sql);
	if ($result[0][0] < $request['created_at']) {
		 $imageUrl = urlencode($request['profile_image_url']);
		$text = addslashes($request['text']);
		$sql = "insert into ta_keyword_message(keyId,profile_image_url,text,from_user,created_at,DT)
			values($id,'{$imageUrl}','{$text}','{$request['from_user']}',{$request['created_at']},'{$phpdate}')";
		executeQuery($sql);
	}
}
function addkeywordUser($request, $keyid) {
	$sql = "Select * from ta_keyword_users where UserId = '{$request['id']}' and keyId='{$keyid}'";
	$db = Mysql :: getInstance();
	$db->Open();
	$nos = $db->NumRows($db->Query($sql));
	$db->Close();
	if ($nos == 0) {
		$sql = "insert into ta_keyword_users(keyId,UserId,CampaignID,Lang,FollowCount) values($keyid,{$request['id']},'{$request['CampaignID']}','{$request['lang']}','{$request['count']}')";
		executeQuery($sql);
		return true;
	} else {
		return false;
	}
}
function removeKeyword($keyword, $campainID) {
	$sql = "SELECT  K.KeyId,U.UserId FROM ta_users U inner join ta_keyword_users KU using (UserId) inner join ta_keyword K using (KeyId) where KU.CampaignID='{$campainID}' and K.Message='{$keyword}'";
	$userDetail = runQuery($sql);
	$sql = "delete from ta_keyword_users where  keyId={$userDetail[0]['KeyId']} and UserId={$userDetail[0]['UserId']}";
	executeQuery($sql);
}
function pausePlay($keyword, $campainID) {
	$sql = "SELECT  KU.* FROM ta_keyword_users KU inner join ta_users U using (UserId) inner join ta_keyword K using (KeyId) where KU.CampaignID='{$campainID}' and K.Message='{$keyword}'";
	$userDetail = runQuery($sql);
	if ($userDetail[0]['KeywordStatus'] == 'A') {
		$KeywordStatus = 'I';
	}
	elseif ($userDetail[0]['KeywordStatus'] == 'I') {
		$KeywordStatus = 'A';
	}
	$sql = "update ta_keyword_users set KeywordStatus='{$KeywordStatus}' where  keyId={$userDetail[0]['keyId']} and UserId={$userDetail[0]['UserId']}";
	executeQuery($sql);
	return $KeywordStatus;
}
/**
 * add/delete follower in keyword follower table
 * @var $status follow=>delete friend//remove=>add friendship
 * @var $user screen name
 * @var name username
 * @var $CampaignID campaignID
 */
function addDeleteFollower($status = 'remove', $user, $name, $CampaignID) {
	$sql1 = "SELECT KM.id , K.KeyID,U.UserID,KU.id as kuid FROM ta_keyword_users KU
				inner join ta_keyword K using (KeyID)
				inner join ta_users U using (UserID)
				inner join ta_keyword_message  KM on KM.KeyID=K.KeyID
				where U.UserName='{$name}' and KU.CampaignID={$CampaignID} and KM.from_user='{$user}'
				group by KU.id";
	$ids = runQuery($sql1);
	$userid=$ids[0]['UserID'];
	$kid=$ids[0]['kuid'];
	if ($status == 'remove') {
	//	$sql = "delete from ta_keyword_follow where keywordMessageId={$ids[0]['id']} and KeywordUserID={$ids[0]['UserID']}";
		$sql = "delete from ta_user_followed_keyword_users where keywordMessageId='$kid' and user_id='$userid'";
	} else {
		//$sql = "insert into ta_keyword_follow (keywordMessageId,KeywordUserID,KeyID) values ({$ids[0]['id']},{$ids[0]['UserID']},{$ids[0]['KeyID']})";
		$sql = "insert into ta_user_followed_keyword_users (user_id,id) values ('$userid','$kid')";
			}
	executeQuery($sql);
	setKeywordfollowersForUserkeyword($CampaignID, $ids[0]['KeyID'], $ids[0]['UserID']);
}
/**
 * update follow count
 */
function updateFollowCount($request){
	$sql="update ta_keyword_users set FollowCount={$request['followCount']} where keyId={$request['KeyId']} AND CampaignID={$request['campainID']} AND UserId={$request['userID']}";
	executeQuery($sql);
}
function sendtemplatemail($from,$to,$mailto,$replyto,$mailsubject,$template)
{
	$sql3 =  "SELECT * FROM ta_email_template WHERE status='Active' and t_id='$template'";
    $gettempdetails3 = runQuery($sql3);
    if(file_exists("../mailtempl/".$gettempdetails3[0]["t_file"]))
				{
				//Output a line of the file until the end is reached
					$file2 = fopen("../mailtempl/".$gettempdetails3[0]["t_file"], "r") or exit("Unable to open file!");
                    $mcontent="Dear {$to},\n"; 
						while(!feof($file2))
					    {
					    	 $mcontent.=fgets($file2);
					    }
						 fclose($file2);
				}
			
	//for sending mail
	$headers = 'From:'.$from."\r\n" .
    'Reply-To: '.$replyto."\r\n" .
	 'X-Mailer: PHP/'.phpversion();
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject=$mailsubject;
	$body=$mcontent;
	$mailto=$mailto;
	mail($mailto, $subject, $body, $headers);
	}
function addapistatinfo($appln, $api,$user, $dt) {
    $dt=date('Y-m-d H:i:s');
    $sql = "insert into ta_api_statistics(application,apitype,username,DT) values ('{$appln}','{$api}','{$user}','{$dt}');";
	return executeQuery($sql);
}
function dkMakeClickableLinks($text) 
{
 	$text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_+.~#?&//=]+)','<a target="_blank" href="\1">\1</a>', $text);
 	$text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_+.~#?&//=]+)','\1<a target="_blank" href="http://\2">\2</a>', $text);
 	$text = eregi_replace('([_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3})', '<a href="mailto:\1">\1</a>', $text);
	return $text;
} 
function fetchtweets($user)
{
	include_once ('secret.php');
	$getuserDet = "SELECT * FROM ta_user_keys WHERE Username='$user'";
	$getuserResults  = runQuery($getuserDet); 
	include_once ('../classes/twitteroauth.php');
	$connection = new TwitterOAuth($consumer_key, $consumer_secret, $getuserResults[0]['key'], $getuserResults[0]['secretkey']);
	$url = "http://twitter.com/statuses/user_timeline/$user.json";
	addapistatinfo("fetchtweets","statuses/user_timeline",$user, "");
	$params     =   array('count' => 3);
	$gettweet = $connection->get($url,$params);
	$result=objectToArray($gettweet);
	for($i=0;$i<count($result);$i++)
		{
			$created =$result[$i]['created_at'];
        	$newdstr=substr($created, 0, 19); 
			echo  "<p>".dkMakeClickableLinks($result[$i]['text'])."<br/>";
			echo  "<span>".$newdstr."</span></p>";
		}
}
function fetchmygroups($username)
{
		$sqlmember = "SELECT distinct ta_group.groupID as ta_groupID,ta_group.groupName as groupName,ta_group.groupImage as groupImage FROM `ta_group`,`ta_group_members` where ta_group_members.memberName='$username' and ta_group_members.groupID=ta_group.groupID order by groupName asc  Limit 3";
		$memberlist = runQuery($sqlmember);	
		if(count($memberlist)>=1)
			{
			for($a=0;$a<count($memberlist);$a++){
			$res.= "<div class=\"group_membersmall\">";
			$res.= "<div class=\"thump_small\"><a href=\"../group/grouphome?id=".$memberlist[$a]['groupID']."\">";
			 if($memberlist[$a]['groupImage']==""){
			$res.="<img src=\"../images/user_photo.jpg\" />";
			 } else if (file_exists("../group/thumbimg/".$memberlist[$a]['groupImage']."")){
			$res.="<img src=\"../group/thumbimg/".$memberlist[$a]['groupImage']."\"/>";
			} else {
			$res.="<img src=\"../group/origimg/".$memberlist[$a]['groupImage']."\" />";
			 }
			$res.=" </a></div><div class=\"thump_smallname\"><a href=\"../group/grouphome?id=".$memberlist[$a]['groupID']."\">".$memberlist[$a]['groupName']."</a></div><div class='clear'></div>				
										</div>";

 }							
							}
							else{
								$res.= "No Groups Found";
										}
		echo $res;								
}
function selectfollowcount($userid,$kuid)
{
	$query="SELECT COUNT(*) AS cnt FROM `ta_user_followed_keyword_users` WHERE `user_id`='$userid' AND `id` = '$kuid'";
	$result = runQuery($query);
	return $result[0]['cnt'];
}
function userfollowcount($userid)
{
	$query="SELECT COUNT(*) AS cnt FROM `ta_user_followed_keyword_users` WHERE `user_id`='$userid'";
	$result = runQuery($query);
	return $result[0]['cnt'];
}
function dkGetUserEmail($uname)
{
	$query="SELECT `Email` FROM `ta_users` WHERE `UserName` = '$uname'";
	$result = runQuery($query);
	if(count($result)>0)
	{
		return $result[0]['Email'];
	}
	else
	{
		return '';
	}
}
function userreports($userid,$campID)
{
	$getcampaignsql = "SELECT ta_category_tweet_messages_status.CampaignId,count(ta_category_tweet_messages_status.CategoryId) as COUNT FROM ta_category_tweet_messages_status,ta_category WHERE ta_category_tweet_messages_status.CampaignId='$campID' and ta_category.id=ta_category_tweet_messages_status.CategoryId";
	$getcampaignsqlresult   = runQuery($getcampaignsql);
	$ctmcount = $getcampaignsqlresult[0]["COUNT"];
	echo "   Total of "."<b>".$ctmcount."</b>"." tweets have been posted for the categories chosen by you.";
	echo "<br/>";
	//For Feed Messages
	//$getfeedsql = "SELECT ta_feeds.feedname as feedname,count(*) as COUNT FROM ta_feeds WHERE ta_feeds.CampaignID='$campID' GROUP BY feedname";
	$getfeedsql ="SELECT f.feedname as feedname,count(*) as COUNT FROM ta_feeds f LEFT JOIN ta_feed_results fr ON f.`id`=fr.`feedid` WHERE f.`CampaignID`='$campID' GROUP BY feedname";
	$getfeedsqlresult   = runQuery($getfeedsql);
	$totfeed="";
	$cfmcount=0;
	if(count($getfeedsqlresult)>0)
	{
	for($u=0;$u<count($getfeedsqlresult);$u++){
	$cfmcount =$cfmcount+$getfeedsqlresult[$u]["COUNT"];
	$totfeed=$totfeed.$getfeedsqlresult[$u]["feedname"].",";
	}
	$totfeed=rtrim($totfeed, ','); 
	echo "   Total of "."<b>".$cfmcount."</b>"." tweets have been posted for the feeds "."<b>".$totfeed."</b>";
	echo "<br/>";
	}
	else{
	echo "   Total of "."<b>".$cfmcount."</b>"." feed tweets have been posted";
	echo "<br/>";	
	}
	//For Future Tweets
	//$getfuturesql = "SELECT count(*) as COUNT FROM  ta_future_tweet_messages_status WHERE CampaignId='$campID'";
	$getfuturesql = "SELECT count(*) as COUNT FROM  ta_future_tweet_messages WHERE CampaignId='$campID' and Status='Y'";
	$getfuturesqlresult   = runQuery($getfuturesql);
	$cftcount = $getfuturesqlresult[0]["COUNT"];
	echo "<b>".$cftcount."</b>"." tweets have been posted from your messages scheduled for future.";
	echo "<br/>";
	//For Keyword users
	$getkeywordsql = "SELECT count(*) as keycount FROM  ta_keyword_users WHERE CampaignID='$campID'";
	$getkeywordsqlresult   = runQuery($getkeywordsql);
	$ckeycount = $getkeywordsqlresult[0]["keycount"];
	$query="SELECT COUNT( * ) AS cnt FROM ta_user_followed_keyword_users a LEFT JOIN ta_keyword_users k ON a.key_id = k.id  WHERE a.`user_id` = '$userid' AND a.key_id IN(SELECT keyId FROM  ta_keyword_users  WHERE CampaignID='$campID' )";
	//$query=" SELECT COUNT( * ) AS cnt FROM ta_user_followed_keyword_users a LEFT JOIN ta_keyword_users k ON a.key_id = k.id  WHERE a.`user_id` = '$userid' AND `CampaignID` = '$campID' ";
	//$query="SELECT COUNT(*) AS cnt FROM `ta_user_followed_keyword_users` WHERE `user_id`='$userid'";
	$result = runQuery($query);
	$ckeyusercount =$result[0]['cnt'];
	echo "<b>".$ckeyusercount."</b>"." users has been followed for "."<b>".$ckeycount."</b>"." keywords ";
	echo "<br/>";
	//For Save Tweets
	$getsavesql = "SELECT count(*) as COUNT FROM  ta_save_tweets WHERE CampaignID='$campID'";
	$getsavesqlresult   = runQuery($getsavesql);
	$cstcount = $getsavesqlresult[0]["COUNT"];
	echo "<b>".$cstcount."</b>"." tweets have been saved ";
	echo "<br/>";
	}
function dktoLink($text) {
	$text = html_entity_decode($text);
	$text = " " . $text;
	$text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="\\1">\\1</a>', $text);
	$text = eregi_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="\\1">\\1</a>', $text);
	$text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a href="http://\\2">\\2</a>', $text);
	$text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})', '<a href="mailto:\\1">\\1</a>', $text);
	return $text;
}
function selectkeywordfollowcount($username,$keyId)
{
    $query="SELECT `UserID` FROM `ta_users` WHERE `UserName`='$username'";
	$result = runQuery($query);
	if(count($result)>0)
	{
	$query="SELECT FollowCount FROM `ta_keyword_users` WHERE `UserId`='".$result[0]['UserID']."' AND `keyId` = '$keyId'";
	$result = runQuery($query);
	if(count($result)>0)
	{
		if(intval($result[0]['FollowCount']))
		{
		if($result[0]['FollowCount']==1)
			{
			return 100;
			}
			else
			{
			return $result[0]['FollowCount'];
			}
		}
		else
		{
			return 0;
		}
		
	}
	else{
	return 0;
	}
	}
	else
	{
	return 0;
	}
}

function clean_keyword($term)
		{
		$term=strtolower($term);
		$code_entities_match = array('--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=');
		$code_entities_replace = array('-','','','','','','','','','','','','','','','','','','','','','','','','');
		$term = str_replace($code_entities_match, $code_entities_replace, $term);
		return $term;
		}
?>