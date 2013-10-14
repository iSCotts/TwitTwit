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
	}
	function friend() {
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->user, $this->password);
		$url = 'http://twitter.com/statuses/friends.json';
		$friend = $connection->get($url);
		$friendcount = count($friend);
		$friends = array ();
		for ($j = 0; $j < $friendcount; $j++) {
			array_push($friends, $friend[$j]->screen_name);
		}
		return $friends;
	}
	function followUser($user) {
		$url = "http://twitter.com/friendships/create/{$user}.json";
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->user, $this->password);
		return $connection->post($url);

	}
	function dkratelimitskey()
	{
		$url = 'http://twitter.com/account/rate_limit_status.json';
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->user, $this->password);
		$remaining_hits = 0;
		$x = get_object_vars($connection->get($url));
		if (array_key_exists('remaining_hits', $x)) $remaining_hits = $x['remaining_hits'];
		return $remaining_hits;
	}
	function dkNotFollowingList()
	{
		echo $this->dkratelimitskey().'<br/>';
		$url = 'http://twitter.com/statuses/followers.json';
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->user, $this->password);
		//$followers = get_object_vars($connection->get($url));
		$followers = $connection->get($url);
		echo '<br/>count of followers : '.count($followers);
		$url = 'http://twitter.com/statuses/friends.json';
		$friends = $connection->get($url);
		echo '<br/>count of friends : '.count($friends);
		
		print_r($followers);
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
	function save($terms = false, $lang = en, $KeyID,$since_id =0,$max_id=0) 
	{ 
		$rpp	= 20;		
		$y		= array();		
		if($since_id == 0 )
		{		
			$x	= objectToArray(parent :: search($terms,$rpp,$lang,false));
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
		echo $terms.' : '.count($y).'<br/>';
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
?>
