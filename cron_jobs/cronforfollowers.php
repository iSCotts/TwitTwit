<?php
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
date_default_timezone_set("America/New_York");
$getuserDetails = "SELECT UserName FROM  ta_users WHERE ACStatus='P'";
$getuserResults  = runQuery($getuserDetails);
$phpdate = date('Y-m-d H:i:s');
//$phpdate = '2010-04-28 01:00:01';
?>
<table border="1" align="center">
<tr><td>User Name</td><td>Followers Count</td><td>Friends Count</td></tr>
<?php 
for($p=0;$p<count($getuserResults);$p++)							
{	
$username=$getuserResults[$p]['UserName'];
//$getfollowerDetails = "SELECT * FROM  ta_follower_count WHERE username='$username'";
//$getfollowerResults  = runQuery($getfollowerDetails);
$xml=file_get_contents('http://twitter.com/users/show.xml?screen_name='.$username);
addapistatinfo("cronforfollowers","users/show","cronfile", $phpdate);
if (preg_match('/followers_count>(.*)</',$xml,$match)!=0) {
    $tw['count'] = $match[1];
}
if (preg_match('/friends_count>(.*)</',$xml,$match1)!=0) {
    $tw['count1'] = $match1[1];
}
if (preg_match('/screen_name>(.*)</',$xml,$match2)!=0) {
    $tw['screenname'] = $match2[1];
}
//fetch the last date
 $selectlastDate = "select max(DT) as lastdate from  ta_follower_count where username='$username'";
$selectlastdtResults  = runQuery($selectlastDate);	
$lastdate=$selectlastdtResults[0]['lastdate'];
if(!empty($lastdate))
{
	//$lastdate='2010-04-24 01:00:03';
	//fetch the datediff
	$datedifference=strtotime($phpdate)-strtotime($lastdate);
	$datedifference=intval($datedifference/(60*60*24));
	//echo "date diff".$datedifference;
	if($datedifference>=1)
	{
	for($i=1;$i<=$datedifference;$i++)
	{
		$nextdate=date('Y-m-d',mktime(0,0,0,date('m',strtotime($lastdate)),date('d',strtotime($lastdate))+$i,date('Y',strtotime($lastdate))));
		//echo "nextdate".$nextdate;
		$insertfollowerDetails = "INSERT INTO ta_follower_count(username,follower,friends,DT) VALUES('$username','$match[1]','$match1[1]','$nextdate')";
		$insertfollowerResults  = runQuery($insertfollowerDetails);	
	}
	
	$insertfollowerDetails = "INSERT INTO ta_follower_count(username,follower,friends,DT) VALUES('$username','$match[1]','$match1[1]','$phpdate')";
	$insertfollowerResults  = runQuery($insertfollowerDetails);	
	}
}
else{
$insertfollowerDetails = "INSERT INTO ta_follower_count(username,follower,friends,DT) VALUES('$username','$match[1]','$match1[1]','$phpdate')";
$insertfollowerResults  = runQuery($insertfollowerDetails);	
}
	
?>
<tr>
<td><?php echo $tw['screenname']; ?></td>
<td><?php echo $tw['count']; ?></td>
<td><?php echo $tw['count1']; ?></td>
</tr>
<?php 
}
?>
</table>
