<?php ob_start();
/*
 * This file updated by : DK
 * 2010/April/24
 * Integrated short_urls_log and tracked all click forward using ip address.
 * 2010/April/26
 * Updated short_urls_log table. ip to location functionality added by using some thrid party tool(API) 
*/		
include_once 'common/dbconfig.php';
include 'classes/class.dkiptolocation.php';
$i = $_SERVER['REQUEST_URI'];
$i = str_replace('/','',$i );
$redirect_url='Location: ';
if (preg_match("/^[0-9a-z]{6}$/", $i)) 
{
    db_connect();
    $result = mysql_query("SELECT id, url FROM `ta_short_urls` WHERE `short` = '$i'") or die(mysql_error());
    if (mysql_num_rows($result) < 1) 
    { 
    	db_close();
    	header($redirect_url.' 404.php');
    }
	else
	{
        $row 			= mysql_fetch_array($result);
		$ip_address 	= '';
		$ip_country 	= '';
		$ip_city 		= '';
		$ip_region 		= '';
		if(isset($_SERVER['REMOTE_ADDR'])) 
		{
			$ip_address 	= $_SERVER['REMOTE_ADDR'];
			$dkIpObj		= new dkIpToLocation();
			$ipDet			= $dkIpObj->getIpLocation($ip_address);
			//print_r($ipDet);
			$ip_country 	= mysql_real_escape_string($ipDet['country']);
			$ip_region		= mysql_real_escape_string($ipDet['region']);
			$ip_city 		= mysql_real_escape_string($ipDet['city']);
		}
		$dkQuery	= "INSERT INTO `ta_short_urls_log`"
					. " (`sul_id` ,`id`,`ip_address`,`ip_country`,`ip_region`,`ip_city` )"
					. " VALUES (NULL , '".$row['id']."', '$ip_address', '$ip_country', '$ip_region', '$ip_city')";
		mysql_query($dkQuery);
		if(strpos($row['url'],'http://') ===0 || strpos($row['url'],'https://')  === 0 || strpos($row['url'],'ftp.') ===0)
		{
			$redirect_url='Location: '.$row['url'];
		}
		else
		{
			$redirect_url='Location: http://'.$row['url'];
		}
		db_close();
	    header($redirect_url);
	}
}
else 	header($redirect_url.' 404.php');
?>