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
	function save($terms = false, $lang = en, $KeyID) {

		$db = Mysql :: getInstance();
		$db->Open();
		$keywordMessages = array ();
		$liveresults = parent :: search($terms, 20, $lang, 1);
		$results = objectToArray($liveresults);
		$results = $results['results'];
		$resultCount = count($results);
		for ($i = 0; $i < $resultCount; $i++) {
			$results[$i]['created_at'] = strtotime($results[$i]['created_at']);
		}
		multi2dSortAsc($results, 'created_at');
		$phpdate = date('Y-m-d H:i:s');
		$sql = "select created_at from ta_keyword_message where keyId={$KeyID} order by created_at desc ";
		$result = $db->FetchArray($db->Query($sql));
		for ($i = 0; $i < $resultCount; $i++) {
			if ($result[0][0] < $results[$i]['created_at'] || !isset ($result[0][0])) {
				$imageUrl = urlencode($results[$i]['profile_image_url']);
				$text = addslashes($results[$i]['text']);
				 $sql = "insert into ta_keyword_message(keyId,profile_image_url,text,from_user,created_at,DT)
																												values($KeyID,'{$imageUrl}','{$text}','{$results[$i]['from_user']}',{$results[$i]['created_at']},'{$phpdate}')";
				$db->Query($sql);
			} else {
				break;
			}
		}
		$db->Close();
	}
}
?>
