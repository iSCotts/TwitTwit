<?php

$page = 'followed.php';

include_once('../classes/dbClient.php');

include_once('../common/sqlFunctions.php');

include_once ('../classes/class.twitter.php');

$user_name	= $_REQUEST['name'];

$key_id		= $_REQUEST['keyID'];

$act		= $_REQUEST['act'];

$km_ids		= $_REQUEST['km_ids'];

$kid		= $_REQUEST['kid'];

$sqlDate	= date('Y-m-d');

$followed_user	= $_REQUEST['followed_user'];

if($act == 'unfollow')

{

	if($kid!='')

	{

	   $getuserDet = "SELECT * FROM ta_user_keys WHERE Username='$user_name'";

	   $getuserResults  = runQuery($getuserDet);

	    include_once ('../classes/twitteroauth.php');

	    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $getuserResults[0]['key'], $getuserResults[0]['secretkey']);

	  	$url = "http://twitter.com/friendships/destroy/{$followed_user}.json";

		$results = $connection->post($url);

		addapistatinfo("unfollow","friendships/destroy",$user_name, $sqlDate); 

		$query = "DELETE FROM `ta_user_followed_keyword_users` WHERE `ufku_id` IN ($kid) ";

		executeQuery($query);

	}

}

else if($act == 'block')

{

	if($km_ids !='')

	{

		$query = "SELECT * FROM `ta_user_followed_keyword_users` WHERE `ufku_id` IN ($km_ids) ";

		$result  = runQuery($query);

		for($i=0;$i<count($result);$i++)

		{

			$query = "INSERT INTO `ta_follow_blocked_user_list` (`fbul_id`, `user_name`, `key_id`, `blocked`, `profile_image_url`, `text`, `date`) VALUES (NULL, '$user_name', '$key_id', '".$result[$i]['followed_user_name']."', '".$result[$i]['profile_image_url']."', '".addslashes($result[$i]['text'])."', '$sqlDate');";

			executeQuery($query);

			}

		$query = "DELETE FROM `ta_user_followed_keyword_users` WHERE `ufku_id` IN ($km_ids) ";

		executeQuery($query);

	}

}



$query = "SELECT COUNT(*) AS cnt FROM `ta_user_followed_keyword_users` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id'";

$resultCnt  = runQuery($query);





// --- pagination section------

include_once('../classes/class.sqlPagination.php');

$pagobj 						= new dkSqlPagination();

$pagobj->url					= '../searchFollow/followed.php';

$pagobj->load_type				= 'ajax';

$pagobj->per_page				= 10;

$pagobj->page_no				= $_REQUEST['pageno'];

$pagobj->query_string_params	= array('message'=>$_REQUEST['message'],'name'=>$user_name,'keyID'=>$key_id,'act'=>'');

$pagobj->ajax_js_function_name	= 'dkListFollowed';

$pagobj->record_count			= $resultCnt [0]['cnt'];

$pRes 							= $pagobj->paginator();

// --- pagination section------

$query = "SELECT * FROM `ta_user_followed_keyword_users` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' $pRes[limit]";

$result  = runQuery($query);

?>

<!-- Followers Area Start -->

<style type="text/css">

.pagination_container { float:left; color:#cc0000; font-weight:bold;}

.pagination_container a { color:#444444; }

.pagination { width:20px; height:20px; border:#999999  1px solid; float:left; margin-left:5px; text-align:center; overflow:hidden; line-height:20px; font-family:Arial, Helvetica, sans-serif; cursor:pointer; font-size:12px; }

.pre { width:60px; height:20px; border:#999999  1px solid; float:left; margin-right:10px; text-align:center; overflow:hidden; line-height:20px; font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer; }

.next { width:60px; height:20px; border:#999999  1px solid; float:left; font-family:Arial, Helvetica, sans-serif; margin-left:13px; text-align:center; overflow:hidden; line-height:20px; font-size:12px; cursor:pointer; }

</style>

<div class="suggesions">

<?php

if(count($result) ==0 )

{

?>

<div class="followers_top">

		<div class="followers_left"></div>

		<div class="followers_middle">

			<div class="followers_middle01">User</div>

			<div class="followers_middle02" style="padding:0 0 0 10px;">Reason</div>

			<!--<div class="followersnew_01">	</div>-->

			<div class="followers_middle03">Unblock</div>

			<div class="clear"></div>

		</div>

		<div class="followers_right"></div>

		<div class="clear"></div>

		</div>

		<div class="followers_data">

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No Records Found

		</div>

<?php

}

else

{

?>


	<div class="followers_top">

		<div class="followers_left"></div>

		<div class="followers_middle">

			<div class="followers_middle01">User</div>

			<div class="followers_middle02" style="padding:0 0 0 10px;">Reason</div>

			<div class="followers_middle03">Unfollow</div>

			<div class="clear"></div>

		</div>

		<div class="followers_right"></div>

		<div class="clear"></div>

	</div>

<form name="suggesions_form">	

<?php

for($i=0;$i<count($result);$i++)

{

?>

	<!-- User Data 01 Start -->

	<div class="followers_data">

		<div class="followers_data01">

			<div class="user_photo"><img src="<?php echo urldecode($result[$i]['profile_image_url']);?>" width="50" height="50" alt="" /></div>

			<div class="user_name">

				<a target="_blank" href="http://www.twitter.com/<?php echo $result[$i]['followed_user_name'];?>"><?php echo $result[$i]['followed_user_name'];?></a>

			</div>

			<div class="clear"></div>

		</div>

		<div class="followersnew_02">

			<p><?php echo dktoLink(stripslashes($result[$i]['text']));?></p>

		</div>

		<div class="followers_data03">

		<div style="padding:0 0 0 40px;"><img src="<?php echo IMG_PATH."unfollow.png";?>" alt="unfollow" style="padding:0 0 0 28px;" onclick ="dkListFollowed('<?php echo $pagobj->page_no; ?>','<?php echo $_REQUEST['message'];?>','<?php echo $user_name;?>','<?php echo $key_id;?>','unfollow','<?php echo $result[$i]['followed_user_name'];?>','<?php echo $result[$i]['ufku_id'];?>')" /></div>

		</div>

		<div class="clear"></div>

	</div>

	<!-- User Data 01 End -->

<?php

}

?>	

</form>

<!-- Pagination Start -->

<div>

	<div class="followersnew_pagiation"><?php echo $pRes['display']; ?></div>

	

	<div class="clear"></div>

</div>

<!-- Pagination End -->

<?php

}

?>

</div>

<!-- Followers Area End -->

/break/

<?php include_once('keyword_statistics.php'); ?>

