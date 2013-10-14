<?php
	$suggestions_class 	= '';
	$queued_class 		= '';
	$followed_class 	= '';
	$blocked_class 		= '';
	switch($page)
	{
		case 'suggestions.php' 	: $suggestions_class 	= ' name="dk_keyword_info" style="color:#5392A6;" '; break;
		case 'queued.php' 		: $queued_class 		= ' name="dk_keyword_info" style="color:#5392A6;" '; break;
		case 'followed.php' 	: $followed_class 		= ' name="dk_keyword_info" style="color:#5392A6;" '; break;
		case 'blocked.php' 		: $blocked_class 		= ' name="dk_keyword_info" style="color:#5392A6;" '; break;
	}
	
	$html = '';
	$suggestions = dkGetSuggestionsUserListCount($user_name,$key_id);
	if($suggestions>0)
	{
		$temp = " $suggestions_class href=\"#{$key_id}\" "
			  . " onclick=\"dkListSuggestions(0,'{$_REQUEST['message']}','{$user_name}' ,'{$key_id}','suggest')\" "
			  . " name=\"{$name}_{$_REQUEST['message']}\"";
		$html .= '<strong  ><a '.$temp.'>Suggestions('.$suggestions.')</a>&nbsp;|&nbsp;</strong>';
	}
	else
	{
		$html .= '<strong  >Suggestions('.$suggestions.')&nbsp;|&nbsp;</strong>';
	}
	$queued = dkGetQueuedUserListCount($user_name,$key_id);
	if($queued>0)
	{
		$temp = " $queued_class href=\"#{$key_id}\" "
			  . " onclick=\"dkListQueued(0,'{$_REQUEST['message']}','{$user_name}' ,'{$key_id}','queued')\" "
			  . " name=\"{$name}_{$_REQUEST['message']}\"";
		$html .= '<strong ><a '.$temp.' >Queued('.$queued.')</a>&nbsp;|&nbsp;</strong>';
	}
	else
	{
		$html .= '<strong >Queued('.$queued.')&nbsp;|&nbsp;</strong>';
	}
	$followed = dkGetFollowedUserListCount($user_name,$key_id);
	if($followed>0)
	{
		$temp = " $followed_class href=\"#{$key_id}\" "
			  . " onclick=\"dkListFollowed(0,'{$_REQUEST['message']}','{$user_name}' ,'{$key_id}','followed')\" "
			  . " name=\"{$name}_{$_REQUEST['message']}\"";
		$html .= '<strong ><a '.$temp.' >Followed('.$followed.')</a>&nbsp;|&nbsp;</strong>';
	}
	else
	{
		$html .= '<strong  >Followed('.$followed.')&nbsp;|&nbsp;</strong>';
	}
	$blocked = dkGetBlockUserListCount($user_name,$key_id);
	if($blocked>0)
	{
		$temp = " $blocked_class href=\"#{$key_id}\" "
			  . " onclick=\"dkListBlocked(0,'{$_REQUEST['message']}','{$user_name}' ,'{$key_id}','blocked')\" "
			  . " name=\"{$name}_{$_REQUEST['message']}\"";
		$html .= '<strong ><a '.$temp.' >Blocked('.$blocked.')</a></strong>';
	}
	else
	{
		$html .= '<strong >Blocked('.$blocked.')</strong>';
	}
	echo $html;
?>
