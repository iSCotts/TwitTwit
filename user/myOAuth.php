<?php
include_once ('../config/config.php');
include_once ('../classes/class.twitter.php');
include_once ('../classes/twitteroauth.php');
class myOAuth extends TwitterOAuth {
	static $user = "";
	static $password = "";
	function __construct($username, $pass) {
	 	$this->user = $username;
		$this->password = $pass;
	}
	function unfollow_user($screen_name='')
	{
		$param = array();
		if(intval($screen_name))
		{
			$param = array('user_id'=>$screen_name);
		}
		else
		{
			$param = array('screen_name'=>$screen_name);
		}
		$url = 'http://twitter.com/friendships/destroy.json';
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->user, $this->password);
		$res = $connection->post($url,$param);
		return $this->objectToArray($res);
	}
    function objectToArray( $object )
    {
        if( !is_object( $object ) && !is_array( $object ) )
        {
            return $object;
        }
        if( is_object( $object ) )
        {
            $object = get_object_vars( $object );
        }
        return array_map( 'objectToArray', $object );
    }
	function not_following_list()
	{
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->user, $this->password);
		$next = -1;
		$f = array();
		do
		{
			$url = 'http://twitter.com/statuses/followers.json';
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
			$url = 'http://twitter.com/statuses/friends.json';
			$followers = get_object_vars($connection->get($url,array('cursor'=>$next)));
			$next = $followers['next_cursor_str'];
			$followers=$followers['users'];
			for($i=0;$i<count($followers);$i++)
			{
				$x   = get_object_vars($followers[$i]);
				if(!in_array($x['screen_name'],$f))
				{
					
					$notf[] = $x['screen_name'];
					$notf[] = $x['id'];
				}
			}
			
		}while($next!=0);
		return $notf;
	}
}