<?php
/*
 * Created on 19-Jan-2010
 * Author :	liju
 * File:	addkeyword.php
 *
 */
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
/**
 * Setting keyword
 */
/**
 * setting username
 */
$name = $_POST['name'];
/**
 * setting Password
 */
$pass = $_POST['pass'];
$uname = $_REQUEST['uname'];
$userdet=getUserId($uname);
$refid=$userdet[0]['RefID'];
/**
 * getting keyword unique id
 */
$term = trim($_POST['addkeyword']);
$dkPackage 			= dkGetPackagedetails($uname);
$dkNoCampaignKeys	= dkGetNoCampaignKeywords($_REQUEST['CampaignID']); 
$filterWords 	= array('the' ,' in' , 'to' , 'out' , 'yes' , 'no' , 'ok', 'etc');
$term=clean_keyword($term);
$term=trim($term);
if($dkNoCampaignKeys >= $dkPackage['keywordLimit'])
{
	$html='error|brk|<span class="error">You have created '.$dkNoCampaignKeys.' campaign keywords and your campaign keyword limit is over. Please <a href="upgrade">upgrade your account.</a></span>';
}
else if(in_array($term,$filterWords) || strlen($term)<3 )
{
	$html='error|brk|<span class="error">Please enter a valid keyword.</span>';
}
else 
{
        $keywordId = getkeyword($term, $_POST['lang']);
		
		/**
		 * getting number of used keywords and total number of keywords
		 */
		//$keywordLimit = getkeywordLimit($name);
		
		$newKeywordId = $keywordId[0]['KeyId'];
		/**
		 * if the keyword is new
		 */
		if (count($keywordId)==0) {
			/**
			 * add new keyword
			 */
			$newKeywordId = addkeywordnew($term, $_POST['lang']);
		}
		
		/**
		 * if the user keyword exceeds the alloted one
		 *
		 *
		 *
		 */
		/**
		* keyword limit temporarly commented
		 */
		//if ($keywordLimit[0]['Limit'] >= $keywordLimit[0]['usedLimit']) {
		/**
		 * Add user with details if not there in table
		 */
		if (addkeywordUser($_POST, $newKeywordId) == true) {
			/**
			 * gets the users keyword from database
			 */
			$usersKeywords = getKeywordSearchForKeyId($newKeywordId);
			/**
			 * printing to variable
			 */
		
			setKeywordfollowersForUserkeyword($_POST['CampaignID'], $usersKeywords[0]['KeyId'], $usersKeywords[0]['UserId']);
		
			$html=quickKeywordRun($usersKeywords[0], $_POST['CampaignID'], $uname);
		} else {
			$query="select ta_campaigns.CampaignName as campaignname from ta_campaigns,ta_keyword_users where ta_keyword_users.keyId='$newKeywordId' and ta_keyword_users.CampaignID=ta_campaigns.CampaignID and ta_campaigns.RefID =' $refid'";
			$result = runQuery($query);
			$campaignname=$result[0]['campaignname'];
			if(count($result>0))
			{
			$html="<div class=\"forms01\" id=\"tlerror\"\"><span style=\"color:red\">This keyword is already added for this user in the campaign "."<b>".$campaignname."<b>"."</span></div>";
			}
			}
			$dkNoCampaignKeys++;
			if($dkNoCampaignKeys >= $dkPackage['keywordLimit'])
			{
				$html='msg|brk|<span class="error">You have created '.$dkNoCampaignKeys.' campaign keywords and your campaign keyword limit is over. Please <a href="upgrade">upgrade your account.</a></span>|brk|'.$html;
			}
  }	
  
print $html;
?>