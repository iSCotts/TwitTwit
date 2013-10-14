<?php
/*
 * Created on 07-April-2010
 * Author :	
 * File:	massfollow.php
 *
 */

include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');

session_start();
if($_SESSION["username"] != "" && $_SESSION["password"] !="" )
{
/**
 * get user id and passwords
 */
if(isset($_REQUEST['submit']))
{
$follower=$_SESSION["username"];
$newuser=$_POST['name'];
$getIDs = getUserPASSId($follower);
$dt = date('Y-m-d');
	/**
		 * initilize with twitter Api
		 */
		addapistatinfo("massfollow","account/verify_credentials",$newuser, $dt); 
		if ($getIDs[0]['type'] == 'no') {
		include ('../classes/twitteroauth.php');
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $getIDs[0]['key'], $getIDs[0]['secretkey']);
		
		$username = $getIDs[0]['key'];
		
		$password = $getIDs[0]['secretkey'];
		$url = "http://twitter.com/account/verify_credentials.json";
		
		$httpReq = curl_init();
		curl_setopt($httpReq, CURLOPT_URL, $url);
		curl_setopt($httpReq, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($httpReq, CURLOPT_USERPWD, $username . ':' . $password);
		
		$jsonret = curl_exec($httpReq);
		curl_close($httpReq);
		
		$data = json_decode($jsonret);	
		$fcount= $data->friends_count;
	}
	elseif ($getIDs[0]['type'] == 'yes') {
		include ('../classes/class.twitter.php');
		$summize = new summize($_POST['name'], $getIDs[0]['secretkey']);
		
		$username = $follower;
		
		$password = $getIDs[0]['secretkey'];
		$url = "http://twitter.com/account/verify_credentials.json";
		
		$httpReq = curl_init();
		curl_setopt($httpReq, CURLOPT_URL, $url);
		curl_setopt($httpReq, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($httpReq, CURLOPT_USERPWD, $username . ':' . $password);
		
		$jsonret = curl_exec($httpReq);
		curl_close($httpReq);
		
		$data = json_decode($jsonret);	
		$fcount= $data->friends_count;
		}
	
	/**
	 * friend list
	 */
	addapistatinfo("massfollow","statuses/friends",$newuser, $dt); 
	$totalpage=($fcount/100)+1;
	$next=-1;
	for($i=1;$i<$totalpage;$i++)
	{
		if ($getIDs[0]['type'] == 'no') {
			$friend = array ();
			$friend= $connection->get('http://twitter.com/statuses/friends.json?screen_name='.$newuser.'&cursor='.$next);
				}
		elseif ($getIDs[0]['type'] == 'yes') {
			$friend = $summize->friendscursor($next,$newuser);
			//$friend = $summize->friends();
						}
	
	if($friend=="")
	{
		$res="please enter a valid twitter username";
		
	}
	else{
//	$friend2 = array ();
	
	$friendcount = count($friend);
	for ($k = 0; $k < 100; $k++) {
		//array_push($friend, $friend[$k]->screen_name);
		$friendname=$friend->users[$k]->screen_name;
		$sqlfollowinsert ="INSERT INTO `ta_mass_follow` (`followfrom`,`followto`,`curdate`)	VALUES ('$follower', '$friendname','$dt')";	
		$result=runQuery($sqlfollowinsert);
		echo "<pre>";
		print $friendname;	
		echo "</pre>";
	}
	//echo "friendname".$friendname=$friend->users[0]->screen_name;
	 $next=$friend->next_cursor_str;			
   //	echo "<pre>";
   //   print_r($friend);
	//echo "</pre>";
   }
	}
	$sqlfollowdelete ="delete from `ta_mass_follow` where followto=''";	
	$result2=runQuery($sqlfollowdelete);	
}

?>
<form name="followfrm" action="massfollow.php" method="post">
<table>
<tr><td><?php echo $res;?></td></tr>
<tr><td>Enter the twitter user name to mass follow</td></tr>
<tr><td>
<input type="text" name="name" id="name" /><br/></td></tr>
<tr><td><input type="submit" name="submit" value="submit"></input></td></tr>
</table>
</form>
<?php }
else
{
	header("Location:../index.php");	
}
?>