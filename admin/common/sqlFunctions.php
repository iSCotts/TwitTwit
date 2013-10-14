<?php
 include_once "../config/config.php";
$consumer_key =CONSUMER_KEY;
$consumer_secret = CONSUMER_SECRET;
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
/*
Function for selecting the free users
*/
function getFreeuserdetails() {
	$query = "SELECT * FROM `ta_user_subscriptions` us  LEFT JOIN `ta_user_keys` uk ON us.UserName=uk.UserName WHERE PackageID ='0'";
	return runQuery($query);
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

function sendtemplatemail($from,$to,$mailto,$replyto,$mailsubject,$template)
{
	$sql3 =  "SELECT * FROM ta_email_template WHERE status='Active' and t_id='$template'";
    $gettempdetails3 = runQuery($sql3);
    if(file_exists("../../mailtempl/".$gettempdetails3[0]["t_file"]))
				{
				//Output a line of the file until the end is reached
					$file2 = fopen("../../mailtempl/".$gettempdetails3[0]["t_file"], "r") or exit("Unable to open file!");
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
	$sql = "insert into ta_api_statistics(application,apitype,username,DT) values ('{$appln}','{$api}','{$user}','{$dt}');";
	return executeQuery($sql);
}
function dkGenerateUrl($numAlpha=6)
{
   $listAlpha = 'abcdefghijklmnopqrstuvwxyz0123456789';
   return str_shuffle(substr(str_shuffle($listAlpha),0,$numAlpha));
}
function dkGetUrl($in='',$campaignID = '',$appType = '',$comId = '')
{
    db_connect();
	$query 			= "SELECT short  FROM `ta_short_urls` WHERE `url` = '$in' AND campaign_id = '$campaignID' ";
	$result 		= mysql_query($query) or die('db error');
	if(mysql_num_rows($result) >0)
	{
		$resultTemp = mysql_fetch_array($result);
		$out 		= $resultTemp['short']; 
	}
	else
	{
		do
		{
			 $out 		= dkGenerateUrl();
			 $query 	= "SELECT short  FROM `ta_short_urls` WHERE `short` = '$out'";
			 $result 	= mysql_query($query);
		} while (mysql_num_rows($result) >0);
		$query 	= " INSERT INTO `ta_short_urls` ( `id` , `campaign_id` , `app_type` , `com_id` , `short` , `url` , `stamped` , `mc` ) VALUES ( NULL , '$campaignID', '$appType', '$comId', '$out', '$in', NOW(), '0' ) ";
		mysql_query($query);
	}
	db_close();
	return SITE_URL.$out;
}
function dkIsShortUrl($url) 
{
 	$temp   = explode('twitjix.com/',$url);
	if(count($temp) < 1) return false;
	$i		= $temp[count($temp)-1];
	if (!preg_match("/^[0-9a-z]{6}$/", $i))  return false;
	else
	{
		db_connect();
		$result = mysql_query("SELECT url FROM `ta_short_urls` WHERE `short` = '$i'") or die(mysql_error());
		db_close();
		if (mysql_num_rows($result) > 0)   return true;
		else return false;
	}
}
function dkUrlHttpExistance($url) 
{
 return (($fp = @fopen($url, 'r')) === false) ? false : @fclose($fp);
}
function dkhaveWWW($url) 
{
 if(strpos($url,'www.') ===0 && strlen($url) >7) return true;
 else return false;
}
function dkCreatStringWithShortUrls($campaignID = '',$appType = '',$comId = '',$text = '') 
{
	if(isset($campaignID) && !empty($appType)  && isset($comId) && !empty($text))
	{
		$dkTemp 	= explode(' ',$text);
		$text		= '';
		for($i=0;$i<count($dkTemp);$i++)
		{
			$url		= trim($dkTemp[$i]);
			$urlFlag	= false;
			if(filter_var($url, FILTER_VALIDATE_URL)) $urlFlag	= true;
			else if(dkhaveWWW($url)) $urlFlag	= true;
			else if(dkUrlHttpExistance($url)) $urlFlag	= true;
			//if($urlFlag && !dkIsShortUrl($url))
			if($urlFlag)
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

?>