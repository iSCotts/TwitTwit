<?php
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
	return "http://twitjix.com/".$out;
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

/*function addapistatinfo($appln, $api,$user, $dt) {
    db_connect();
	$sql = "insert into ta_api_statistics(application,apitype,username,DT) values ('{$appln}','{$api}','{$user}','{$dt}');";
	$res= mysql_query($query);
	db_close();
	return $res;
}*/