<?php
	$openinviter_settings=array(
		"username"=>"twitacc",
		"private_key"=>"105e020af00ac6248ee5b3c7cd910ad0",
		"cookie_path"=>'/tmp',
		"message_body"=>" Our Twitter solution helps you create, manage and monitor your personal account and helps unleash the true power of your profile.", // www.twitjix.com is the website on your account. If wrong, please update your account at OpenInviter.com
		"message_subject"=>" is inviting you to www.twitjix.com - The Twitter Accelerator", // www.twitjix.com is the website on your account. If wrong, please update your account at OpenInviter.com
		"transport"=>"curl", //Replace "curl" with "wget" if you would like to use wget instead
		"local_debug"=>"on_error", //Available options: on_error => log only requests containing errors; always => log all requests; false => don`t log anything
		"remote_debug"=>FALSE, //When set to TRUE OpenInviter sends debug information to our servers. Set it to FALSE to disable this feature
		"hosted"=>FALSE, //When set to TRUE OpenInviter uses the OpenInviter Hosted Solution servers to import the contacts.
		"proxies"=>array(), //If you want to use a proxy in OpenInviter by adding another key to the array. Example: "proxy_1"=>array("host"=>"1.2.3.4","port"=>"8080","user"=>"user","password"=>"pass")
						   //You can add as many proxies as you want and OpenInviter will randomly choose which one to use on each import.
		"stats"=>TRUE,
		"plugins_cache_time"=>1800,
		"plugins_cache_file"=>"oi_plugins.php",
		"update_files"=>true,
		"stats_user"=>"", //Required to access the stats
		"stats_password"=>"" //Required to access the stats
	);
	?>