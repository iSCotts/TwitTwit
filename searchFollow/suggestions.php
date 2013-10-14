<?php

$page = 'suggestions.php';

include_once('../classes/dbClient.php');

include_once('../common/sqlFunctions.php');

$user_name	= $_REQUEST['name'];

$key_id		= $_REQUEST['keyID'];

$act		= $_REQUEST['act'];

$km_ids		= $_REQUEST['km_ids'];

$sqlDate	= date('Y-m-d');

if($act == 'follow')

{

	if($km_ids !='')

	{

		$query = "SELECT `profile_image_url`, `text`, `from_user` FROM `ta_keyword_message` WHERE `id` IN ($km_ids) ";

		$result  = runQuery($query);

		for($i=0;$i<count($result);$i++)

		{

			$query = "INSERT INTO `ta_follow_queued_user_list` (`fqul_id`, `user_name`, `key_id`, `follow_user_name`, `profile_image_url`, `text`, `date`) VALUES (NULL, '$user_name', '$key_id', '".$result[$i]['from_user']."', '".$result[$i]['profile_image_url']."', '".addslashes($result[$i]['text'])."', '$sqlDate');";

			executeQuery($query);

		}

	}

}

else if($act == 'block')

{

	if($km_ids !='')

	{

		$query = "SELECT `profile_image_url`, `text`, `from_user` FROM `ta_keyword_message` WHERE `id` IN ($km_ids) ";

		$result  = runQuery($query);

		for($i=0;$i<count($result);$i++)

		{

			$query = "INSERT INTO `ta_follow_blocked_user_list` (`fbul_id`, `user_name`, `key_id`, `blocked`, `profile_image_url`, `text`, `date`) VALUES (NULL, '$user_name', '$key_id', '".$result[$i]['from_user']."', '".$result[$i]['profile_image_url']."', '".addslashes($result[$i]['text'])."', '$sqlDate');";

			executeQuery($query);

		}

	}

}

else if($act == 'quickrun')

{

	include_once ('cronClasses.php');

	include_once ('../classes/class.twitter.php');

	include_once ('../common/secret.php');

	$searchKeyword = new SearchFollow($consumer_key, $consumer_secret);
    addapistatinfo("quickrun","friendships/exists","", ""); 
	$searchKeyword ->saveQuickRunKeyword($key_id);

}

// --- pagination section------

include_once('../classes/class.sqlPagination.php');

$r_count = dkGetSuggestionsUserListCount($user_name,$key_id);

if($r_count>10)

{

$pagobj 						= new dkSqlPagination();

$pagobj->url					= '../searchFollow/suggestions.php';

$pagobj->load_type				= 'ajax';

$pagobj->per_page				= 10;

$pagobj->page_no				= $_REQUEST['pageno'];

$pagobj->query_string_params	= array('message'=>$_REQUEST['message'],'name'=>$user_name,'keyID'=>$key_id,'act'=>'');

$pagobj->ajax_js_function_name	= 'dkListSuggestions';

$pagobj->record_count			= $r_count;

$pRes 							= $pagobj->paginator();

}

else

{

	$pRes['limit'] = "LIMIT 0,$r_count ";

	$pRes['display'] = '';

}

// --- pagination section------

$query = "SELECT * FROM `ta_keyword_message` "

	   . " WHERE `keyId` = '$key_id' "

	   . " AND `from_user` NOT IN (SELECT `blocked` FROM `ta_follow_blocked_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ) "

	   . " AND `from_user` NOT IN (SELECT `follow_user_name` FROM `ta_follow_queued_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ) "

	   . " AND `from_user` NOT IN (SELECT `followed_user_name` FROM `ta_user_followed_keyword_users` WHERE `user_name` = '$user_name' )"

	   . " GROUP BY from_user ORDER BY `id` DESC $pRes[limit]";
	   
//-------------------- new query---------------------	   
$fromUser = array();
$in		  = '';
$query = "SELECT DISTINCT `blocked` FROM `ta_follow_blocked_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ";
$temp  = runQuery($query);
for($i=0;$i<count($temp);$i++)
{
	if(empty($in))
	{
		$in.= "'".$temp[$i]['blocked']."'";
	}
	else
	{
		$in.= ", '".$temp[$i]['blocked']."'";
	}
	$fromUser[] = $temp[$i]['blocked'];
}
unset($temp);
$query = "SELECT DISTINCT `follow_user_name` FROM `ta_follow_queued_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id'";
$temp  = runQuery($query);
for($i=0;$i<count($temp);$i++)
{
	if(!in_array($temp[$i]['follow_user_name'],$fromUser))
	{
		if(empty($in))
		{
			$in.= "'".$temp[$i]['follow_user_name']."'";
		}
		else
		{
			$in.= ", '".$temp[$i]['follow_user_name']."'";
		}
		$fromUser[] = $temp[$i]['follow_user_name'];
	}
}
unset($temp);
$query = "SELECT DISTINCT `followed_user_name` FROM `ta_user_followed_keyword_users` WHERE `user_name` = '$user_name' ";
$temp  = runQuery($query);
for($i=0;$i<count($temp);$i++)
{
	if(!in_array($temp[$i]['followed_user_name'],$fromUser))
	{
		if(empty($in))
		{
			$in.= "'".$temp[$i]['followed_user_name']."'";
		}
		else
		{
			$in.= ", '".$temp[$i]['followed_user_name']."'";
		}
		$fromUser[] = $temp[$i]['followed_user_name'];
	}
}
unset($temp);
unset($fromUser);

if(empty($in))
{
$query = "SELECT * FROM `ta_keyword_message` WHERE `keyId` = '$key_id' $pRes[limit]";
}
else
{
$query = "SELECT * FROM `ta_keyword_message` WHERE `keyId` = '$key_id'  AND `from_user` NOT IN ($in) $pRes[limit]";
}
//-------------------- new query---------------------	   
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

			<div class="followersnew">Reason</div>

			<div class="followersnew_01">Follow</div>

			<div class="followersnew_01">Block</div>

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

	<div class="shortcut_dis">

			<h1>Shortcut Keys</h1>

			<ul>

			 <li><span>SHIFT+Hover</span>&nbsp;<strong>to select entries </strong></li>
			 <li><span>CTRL+Hover</span>&nbsp;<strong>to deselect entries</strong></li>

			</ul>

	</div>

	<div class="followers_top">

		<div class="followers_left"></div>

		<div class="followers_middle">

			<div class="followers_middle01">User</div>

			<div class="followersnew">Reason</div>

			<div class="followersnew_01">Follow</div>

			<div class="followersnew_01">Block</div>

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

				<a target="_blank" href="http://www.twitter.com/<?php echo $result[$i]['from_user'];?>"><?php echo $result[$i]['from_user'];?></a>

			</div>

			<div class="clear"></div>

		</div>

		<div class="followersnew_02">

			<p><?php echo dktoLink($result[$i]['text']);?></p>

		</div>

		<div class="followersnew_03" onmouseover="dkChangeSelStatus(this)">

			<input type="checkbox" name="follow_user" value="<?php echo $result[$i]['id'];?>" />

		</div>

		<div class="followersnew_03" onmouseover="dkChangeSelStatus(this)">

			<input type="checkbox" name="block_user" value="<?php echo $result[$i]['id'];?>" />

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

	<div class="followersnew_followbtn">

		<input type="button" value="Block" class="followersnew_followbtn_01" onclick ="dkListSuggestions('<?php echo $pagobj->page_no; ?>','<?php echo $_REQUEST['message'];?>','<?php echo $user_name;?>','<?php echo $key_id;?>','block')"/>

	</div>

	<div class="followersnew_followbtn">

		<input type="button" value="Follow" class="followersnew_followbtn_01" onclick ="dkListSuggestions('<?php echo $pagobj->page_no; ?>','<?php echo $_REQUEST['message'];?>','<?php echo $user_name;?>','<?php echo $key_id;?>','follow')"/>

	</div>

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

