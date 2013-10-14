<?php
/*
 * Created on 01-Feb-2010
 * Author :	liju
 * File:	cronClasses.php
 *
 */
include ('../config/config.php');
include_once ('../classes/Database.php');
include_once ('../classes/Mysql.php');
include_once ('../classes/class.twitter.php');
include_once ('../classes/twitteroauth.php');
class SearchFollowAPI extends TwitterOAuth {
	static $user = "";
	static $password = "";
	function __construct($username, $pass) {
	 	$this->user = $username;
		$this->password = $pass;
    	addapistatinfo2("oauth","oauth/access_token",$username,"");
		addapistatinfo2("oauth","oauth/authenticate",$username,"");
		addapistatinfo2("oauth","oauth/authorize",$username,"");
		addapistatinfo2("oauth","oauth/request_token",$username,"");
	}
	function friend() {
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->user, $this->password);
		$url = 'http://twitter.com/statuses/friends.json';
		addapistatinfo2("follow","statuses/friends",$user,"");
		$friend = $connection->get($url);
		$friendcount = count($friend);
		$friends = array ();
		for ($j = 0; $j < $friendcount; $j++) {
			array_push($friends, $friend[$j]->screen_name);
		}
		return $friends;
	}
	function followUser($user) {
	    addapistatinfo2("follow","friendships/create",$user,"");
		$url = "http://twitter.com/friendships/create/{$user}.json";
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->user, $this->password);
		return $connection->post($url);

	}
	function dkratelimitskey()
	{
	    addapistatinfo2("ratelimit","account/rate_limit_status","","");
		$url = 'http://twitter.com/account/rate_limit_status.json';
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->user, $this->password);
		$remaining_hits = 0;
		$x = get_object_vars($connection->get($url));
		if (array_key_exists('remaining_hits', $x)) $remaining_hits = $x['remaining_hits'];
		return $remaining_hits;
	}
	function dkUnfollowUser($screen_name='')
	{
	    addapistatinfo2("unfollow","friendships/destroy",$screen_name,"");
		$url = 'http://twitter.com/friendships/destroy.json';
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->user, $this->password);
		$connection->post($url,array('screen_name'=>$screen_name));
	}
	function dkNotFollowingList()
	{
		if($this->dkratelimitskey() == 0) return false;
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->user, $this->password);
		echo 'connection-';
		$next = -1;
		$f = array();
		do
		{
			$url = 'http://twitter.com/statuses/followers.json';
			addapistatinfo2("tweetsearch","statuses/followers","","");
			$followers = get_object_vars($connection->get($url,array('cursor'=>$next)));
			$next = $followers['next_cursor_str'];
			$followers=$followers['users'];
			for($i=0;$i<count($followers);$i++)
			{
				$x   = get_object_vars($followers[$i]);
				$f[] = $x['screen_name'];
			}
			
		}while($next!=0);
		
		$next = -1;
		$notf = array();
		do
		{
		    addapistatinfo2("tweetsearch","statuses/friends","","");
			echo 'x-';
			$url = 'http://twitter.com/statuses/friends.json';
			echo 'x2';
			$followers = get_object_vars($connection->get($url,array('cursor'=>$next)));
			$next = $followers['next_cursor_str'];
			echo 'x3';
			$followers=$followers['users'];
			echo count($followers);
			for($i=0;$i<count($followers);$i++)
			{
				$x   = get_object_vars($followers[$i]);
				
				if(!in_array($x['screen_name'],$f))
				{
					
					$notf[$x['screen_name']] = $x['profile_image_url'];
				}
			}
			
		}while($next!=0);
		return $notf;
	}
}
class SearchFollow extends summize {
	protected $db;
	protected $result;
	function __constructor($user, $pass) {
		parent :: __constructor($user, $pass);
	}
	function friend() {
		$friend=parent :: friends('',-1);
		 $friendcount = count($friend);

		 $friends = array ();
		for ($j = 0; $j < $friendcount; $j++) {
			array_push($friends, $friend[$j]->screen_name);
		}
		return $friends;
	}
	function followUser($user) {

		return parent :: followUser($user);

	}
	function saveQuickRunKeyword($KeyID) 
	{ 
		$db = Mysql :: getInstance();
		$db->Open();
		$query = "SELECT `Message`, `lang`, `since_id`, `max_id` FROM `ta_keyword` WHERE `KeyID` ='$KeyID'";
		$dkDBRes = $db->FetchArray($db->Query($query));
		$db->Close();
		if(count($dkDBRes>0))
		{
			$rpp	= 15;
			$this->save($dkDBRes[0]['Message'], $dkDBRes[0]['lang'], $KeyID,$dkDBRes[0]['since_id'],$dkDBRes[0]['max_id'],$rpp);
		}
	}
	function save($terms = false, $lang = en, $KeyID,$since_id =0,$max_id=0,$rpp	= 20) 
	{ 
		//$rpp	= 20;		
		$y		= array();	
		if($since_id == 0 )
		{		
			$x	= objectToArray(parent :: search($terms,$rpp,$lang,false));
			//addapistatinfo2("tweetsearch","search.twitter.com/search","","");
			if(count($x['results'])>0)
			{
				$since_id	= $x['since_id'];
				if(!intval($since_id) && intval($x['max_id']))
				$since_id	= $x['max_id'];
				$max_id		= $x['max_id']; 
				$y 			= $x['results'];
			}
		}
		else
		{
			$x	= objectToArray(parent :: search($terms,$rpp,$lang,false,$since_id));
			//addapistatinfo2("tweetsearch","search.twitter.com/search","","");
			if(count($x['results'])>0)
			{
				$since_id	= $x['since_id']; 
				$y 			= $x['results'];
			}
			else
			{
				$x	= objectToArray(parent :: search($terms,$rpp,$lang,false,$max_id));
				if(count($x['results'])>0 && $max_id !=-1 && $max_id !=0)
				{
					$max_id		= $x['max_id']; 
					$y 			= $x['results'];
				}
			}
		}
		//echo ' RPP '.$rpp.'//'.$terms.' : '.count($y).'<br/>';
		if(count($y)>0)
		{
			$db = Mysql :: getInstance();
			$db->Open();
			$query		= "UPDATE `ta_keyword` SET `since_id` = '$since_id',`max_id` = '$max_id' WHERE `KeyID` ='$KeyID' LIMIT 1 ";
			$db->Query($query);
			$query = '';
			for ($i = 0; $i < count($y); $i++) 
			{
				$imageUrl = urlencode($y[$i]['profile_image_url']);
				$text = addslashes($y[$i]['text']);
				if(!empty($query)) $query.= " , ";
				$query.= " ('$KeyID','$imageUrl','$text','".$y[$i]['from_user']."','".strtotime($y[$i]['created_at'])."','".date('Y-m-d')."') ";
			}
			$query = " insert into ta_keyword_message(keyId,profile_image_url,text,from_user,created_at,DT) values $query ;";
			$db->Query($query);
			$db->Close();
		}
	}
}
function dkGetUserKeys($username)
{
	$db = Mysql :: getInstance();
	$db->Open();
	$query = "SELECT `key`, `secretkey` FROM `ta_user_keys` WHERE `Username` = '$username'";
	$queryResults = $db->FetchArray($db->Query($query));
	$db->Close();
	return $queryResults;
}
function addapistatinfo2($appln, $api,$user, $dt) {
    $dt=date('Y-m-d H:i:s');
    $db = Mysql :: getInstance();
	$db->Open();
	$sql = "insert into ta_api_statistics(application,apitype,username,DT) values ('{$appln}','{$api}','{$user}','{$dt}');";
	$db->Query($sql);
	$db->Close();
}
?>
