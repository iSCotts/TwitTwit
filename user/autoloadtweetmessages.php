<?php
include_once '../common/dbconfig.php';
$selecetedarray = $_REQUEST["selecetedarray"];
// get tweet message using category id
$joinarray = explode(",",$selecetedarray);
$limitid = count($joinarray);
$tmessage = '';
$gettweetmessage = "SELECT * FROM ta_category_tweet_messages  WHERE categoryid IN ($selecetedarray) LIMIT 0,$limitid";
db_connect();
$gettweetmessageresult  = mysql_query($gettweetmessage);
db_close();
while($gettweetmessageresultvalue = mysql_fetch_array($gettweetmessageresult))
{
	$tmessage .= stripslashes($gettweetmessageresultvalue["TweetMesasge"])."\n\n";
}
echo $tmessage;
 	