<?php
/*
 * Created on 07-April-2010
 * Author :	
 * File:	massfollow.php
 *
 */
include_once ('../classes/dbClient.php');
include_once ('../common/sqlFunctions.php');
include ('../classes/twitteroauth.php');
session_start();
$newuser=$_REQUEST['name'];
$follower=$_SESSION["username"];
$getIDs = getUserPASSId($follower);
$dt=date('Y-m-d H:i:s');
$oAuthObj 		= new TwitterOAuth($consumer_key,$consumer_secret);
$url 			= 'http://twitter.com/users/show.json';
$x 				= get_object_vars($oAuthObj->get($url,array('screen_name'=>$newuser)));
if($x['error'] !='') 
{
 $res= "Not a valid twitter username.";
 }
else if($newuser!=$follower){
    $xml=file_get_contents('http://twitter.com/users/show.xml?screen_name='. $newuser);
	addapistatinfo("massfollow","users/show",$newuser, $phpdate);
	if (preg_match('/friends_count>(.*)</',$xml,$match1)!=0)
	 {
		$fcount=$match1[1];
	 }
	if ($getIDs[0]['type'] == 'no') 
	{
		//	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $getIDs[0]['key'], $getIDs[0]['secretkey']);
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,'','');
		//addapistatinfo("massfollow","statuses/friends",$username, $dt); 
	}
	$totalpage=($fcount/5000)+1;
	$next=-1;
	if($fcount<=1)
	{
		$res="The user  has no friends";
	}
	for($i=1;$i<$totalpage;$i++)
	{
	   if ($getIDs[0]['type'] == 'no') 
	   {
			$friend = array ();
		//	$friend= $connection->get('http://twitter.com/friends/ids.json?screen_name='.$newuser.'&cursor='.$next);
			$friend= $connection->get('http://twitter.com/friends/ids/'.$newuser.'.json?cursor='.$next);
			addapistatinfo("massfollow","friends/ids",$newuser, $phpdate);
			$friend=objectToArray($friend);
		}
	
		if(count($friend)==0)
		{
			
			$res="please enter a valid twitter username";	
		}
		else
		{ 
		if($fcount>5000)
		{
		$climit=5000;
		}
		else{
		$climit=$fcount;
		}
				for ($k = 0; $k <$climit; $k++)
				 {
					$friendname=$friend[$k];
					$sqlfollowinsert ="INSERT INTO `ta_mass_follow` (`followfrom`,`followto`,`curdate`)	VALUES ('$follower', '$friendname','$dt')";	
					$result=runQuery($sqlfollowinsert);
				  }
				$next=$friend[next_cursor_str];			
				$res="You have followed all friends of ".$_REQUEST['name'];
			}
		}
	$sqlfollowdelete ="delete from `ta_mass_follow` where followto=''";	
	$result2=runQuery($sqlfollowdelete);
	}
else{
$res= "please enter a different twitter username.";
}
echo  $res;	
?>
