<?php
/*
 * Created on 28-Jan-2010
 * Author :	liju
 * File:	commonfunctions.php
 *
 */
function PostTweetUsingTokens($consumer_key, $consumer_secret, $token, $secret, $status) {
	print $toc = new TwitterOAuth($consumer_key, $consumer_secret, $token, $secret, $status);
	try {
		$to = new TwitterOAuth($consumer_key, $consumer_secret, $token, $secret);
		$params = array (
			'status' => $status
		);
		print $do_dm = simplexml_load_string($to->oAuthRequest('http://twitter.com/statuses/update.xml', 'POST', $params));
		exit;
	} catch (Exception $o) {
		return print_r($o);
	}
}
/**
* Gets the followers count using API
*/
function GetFollowersCount($userid) {
	$jsonurl = "http://twitter.com/followers/ids.json?user=" . $userid;
	$abc = @ file_get_contents($jsonurl);
	$s = explode(",", $abc);
	return count($s);
}
/**
 * sorting array
 */
function multi2dSortAsc(& $arr, $key) {
	$sort_col = array ();
	foreach ($arr as $sub)
		$sort_col[] = $sub[$key];
	array_multisort($sort_col, $arr);
}
/**
 *
 * Convert an object to an array
 *
 * @param    object  $object The object to convert
 * @reeturn      array
 *
 */
function objectToArray($object) {
	if (!is_object($object) && !is_array($object)) {
		return $object;
	}
	if (is_object($object)) {
		$object = get_object_vars($object);
	}
	return array_map('objectToArray', $object);
}
/**
 * display quick run
 * @var $resultCount result count number
 * @var $results twitter search result
 * @var $getIDs user password/username
 * @var $friends twitter friend list
 * @var $db boolean true if search from database/false for live search
 * @var $campainID campaign ID
 * @var $message Keyword
 */
function displayQuickrun($resultCount, $results, $getIDs, $friends, $db, $campainID, $message,$KeyID) {
	$output = "<div class=\"editaccounts\">
													<div class=\"followers_top\">
														<div class=\"followers_left\"></div>
														<div class=\"followers_middle\">
															<div class=\"followers_middle01\">User</div>
															<div class=\"followers_middle02\">Reason</div>
															<div class=\"followers_middle03\">Action</div>
															<div class=\"clear\"></div>
														</div>
														<div class=\"followers_right\"></div>
														<div class=\"clear\"></div>
										</div><table cellpadding=\"0\"; cellspacing=\"0\">";
	if ($resultCount==0) {
		$output .= "<tr><td><div  class=\"followers_data\">No Records found</div></td></tr></table>";
		return $output;
	}

	for ($i = 0; $i < $resultCount; $i++) {
		
		$result = $results["results"][$i];
		if($getIDs[0]['Username']!=$result[from_user])
		{
		//$result = $results[$i][results];
		if ($db) {
			$result[text] = stripslashes($result[text]);
			$result[profile_image_url] = urldecode($result[profile_image_url]);
		}
		$text_n = toLink($result[text]);
		if ((in_array($result[from_user], $friends))) {
			$val = "onclick=\"followstatus('remove','{$getIDs[0]['Username']}','follow{$result[from_user]}','{$result[from_user]}','{$campainID}','{$message}','{$KeyID}');\"";
			$followstatus = "<a {$val} title=\"Click to Unfollow {$result[from_user]}\"><img src=\"../images/unfollow.png\" alt=\"\" /></a>";
		} 
		else {
		$val = "onclick=\"followstatus('follow','{$getIDs[0]['Username']}','follow{$result[from_user]}','{$result[from_user]}','{$campainID}','{$message}','{$KeyID}');\"";
			$followstatus = "<a {$val} title=\"Click to Follow {$result[from_user]}\"><img src=\"../images/follow.png\" alt=\"\" /></a>";
	}
		$output .= "<!-- User Data {$i} Start -->";
		$output .= "	<tr><td>";
		$output .= "	<div  class=\"followers_data\">";
		$output .= "	<div class=\"followers_data01\">";
		$output .= "	<div class=\"user_photo\"><img src=\"{$result[profile_image_url]}\" width=\"50\" height=\"50\" alt=\"\" /></div>";
		$output .= "	<div class=\"user_name\"><a href=\"http://www.twitter.com/{$result[from_user]}\">{$result[from_user]}</a></div>";
		$output .= "	<div class=\"clear\"></div>";
		$output .= "	</div>";
		$output .= "	<div class=\"followers_data02\"><p>";
		$output .= $text_n;
		$output .= "	</p></div>";
		$output .= "	<div id=\"follow{$result[from_user]}\" class=\"followers_data03\">{$followstatus}</div>";
		$output .= "	<div class=\"clear\"></div>";
		$output .= "	</div></td></tr>";
		$output .= "	<!-- User Data {$i} End -->";
	  }
	}
	$output .= "	</table>";
	return $output;
	}
function displayQuickrunfrmdb($resultCount, $results, $getIDs, $friends, $db, $campainID, $message,$KeyID) {
	$output = "<div class=\"editaccounts\">
													<div class=\"followers_top\">
														<div class=\"followers_left\"></div>
														<div class=\"followers_middle\">
															<div class=\"followers_middle01\">User</div>
															<div class=\"followers_middle02\">Reason</div>
															<div class=\"followers_middle03\">Action</div>
															<div class=\"clear\"></div>
														</div>
														<div class=\"followers_right\"></div>
														<div class=\"clear\"></div>
										</div><table cellpadding=\"0\"; cellspacing=\"0\">";
	if ($resultCount==0) {
		$output .= "<tr><td><div  class=\"followers_data\">No Records found</div></td></tr></table>";
		return $output;
	}
	$tempX = array();
	for ($i = 0; $i < $resultCount; $i++) {
		$result = $results[$i];
		if($getIDs[0]['Username']!=$result[from_user])
		{
		//$result = $results[$i][results];
		if ($db) {
			$result[text] = stripslashes($result[text]);
			$result[profile_image_url] = urldecode($result[profile_image_url]);
		}
		//if(in_array('1a', $tempX) ) echo 'hi';
		//print_r($temp);
		//echo $result[from_user];
		$text_n = toLink($result[text]);
		if (!in_array($result['from_user'], $tempX) )
		{
		$tempX[] = $result[from_user];
		if (in_array($result['from_user'], $friends) ) {
			$val = "onclick=\"followstatus('remove','{$getIDs[0]['Username']}','follow{$result[from_user]}','{$result[from_user]}','{$campainID}','{$message}','{$KeyID}');\"";
			$followstatus = "<a {$val} title=\"Click to Unfollow {$result[from_user]}\"><img src=\"../images/unfollow.png\" alt=\"\" />";
		} 
		else
		 {
			$val = "onclick=\"followstatus('follow','{$getIDs[0]['Username']}','follow{$result[from_user]}','{$result[from_user]}','{$campainID}','{$message}','{$KeyID}');\"";
	 $followstatus = "<a {$val} title=\"Click to Follow {$result[from_user]}\"><img src=\"../images/follow.png\" alt=\"\" /></a>";
		}
		$output .= "<!-- User Data {$i} Start -->";
		$output .= "	<tr><td>";
		$output .= "	<div  class=\"followers_data\">";
		$output .= "	<div class=\"followers_data01\">";
		$output .= "	<div class=\"user_photo\"><img src=\"{$result[profile_image_url]}\" width=\"50\" height=\"50\" alt=\"\" /></div>";
		$output .= "	<div class=\"user_name\"><a href=\"http://www.twitter.com/{$result[from_user]}\">{$result[from_user]}</a></div>";
		$output .= "	<div class=\"clear\"></div>";
		$output .= "	</div>";
		$output .= "	<div class=\"followers_data02\"><p>";
		$output .= $text_n;
		$output .= "	</p></div>";
		$output .= "	<div id=\"follow{$result[from_user]}\" class=\"followers_data03\">{$followstatus}</div>";
		$output .= "	<div class=\"clear\"></div>";
		$output .= "	</div></td></tr>";
		$output .= "	<!-- User Data {$i} End -->";
		}
	 }
	}
	$output .= "	</table>";
	return $output;
}
/*function displayQuickrun($resultCount, $results, $getIDs,  $friends, $db,$campainID,$message) {
	if($resultCount>0)
	{
	$output = "";
	$output.="<div class=\"followers_top\">
			<div class=\"followers_left\"></div>
			<div class=\"followers_middle\">
			<div class=\"followers_middle01\">User</div>
			<div class=\"followers_middle02\">Reason</div>
			<div class=\"followers_middle03\">Action</div>
			<div class=\"clear\"></div>
			</div>
			<div class=\"followers_right\"></div>
			<div class=\"clear\"></div>
			</div>";
	}
	for ($i = 0; $i < $resultCount; $i++) {
		$result = $results[$i];
		if ($db) {
			$result[text] = stripslashes($result[text]);
			$result[profile_image_url] = urldecode($result[profile_image_url]);
		}
		$text_n = toLink($result[text]);
		if (in_array($result[from_user], $friends)) {
			$val = "onclick=\"followstatus('remove','{$getIDs[0]['Username']}','follow{$result[from_user]}','{$result[from_user]}','{$campainID}','{$message}');\"";
			$followstatus = '<a ' . $val . ' title="Click to Unfollow ' . $result[from_user] . '">Remove</a>';
		} else {
			$val = "onclick=\"followstatus('follow','{$getIDs[0]['Username']}','follow{$result[from_user]}','{$result[from_user]}','{$campainID}','{$message}');\"";
			$followstatus = '<a ' . $val . ' title="Click to Follow ' . $result[from_user] . '">Follow</a>';
		}
		//added by divya on Feb22
$output .="<div class=\"followers_data\">
		<div class=\"followers_data01\">
		<div class=\"user_photo\"><img src='$result[profile_image_url]' class=\"twitter_image\"  alt=\"\" height=\"50\" width=\"50\"></div>

		<div class=\"user_name\"><a href=\"http://www.twitter.com/\".$result[from_user]>$result[from_user]</a></div>
		<div class=\"clear\"></div>
		</div>
		<div class=\"followers_data02\">
		<p>$text_n</p>
		</div>
		<div class=\"followers_data03\"><div id=follow' . $result[from_user] . '>$followstatus</div></div>
		<div class=\"clear\"></div>
		</div>";
		*/
	/*	$output .= "<tr>";
		$output .= '<td class=bg_none><img src="' . $result[profile_image_url] . '" class="twitter_image" width=50 height=50></td>';
		$output .= '<td class=bg_none><a href="http://www.twitter.com/' . $result[from_user] . '">' . $result[from_user] . '</a></td> ';
		$output .= '</td>';
		$output .= '<td class=bg_none>' . $text_n . '</td>';
		$output .= '<td class=bg_none><div id=follow' . $result[from_user] . '>' . $followstatus . ' </div></td>';
		$output .= '</tr>';
		*/
	//}
	//return $output;
//}
function quickKeywordRun($usersKeywords, $CampaignID, $name) {
	$newmsg=str_replace (" ", "", $usersKeywords['Message']);
	//$usersKeywords['Message']=urlencode($usersKeywords['Message']);
	$html = "<tr class=bg_none><td  class=bg_none><div class=\"forms01\" id=\"tr{$newmsg}1\">";
	$html .= "\n<ul>";
	//$usersKeywords['Message']=urldecode($usersKeywords['Message']);
	$html .= "\n<li><strong>{$usersKeywords['Message']}</strong></li>";
	//$usersKeywords['Message']=urlencode($usersKeywords['Message']);
	$temp = " href=\"#{$usersKeywords['KeyId']}\" "
		  . " onclick=\"dkListSuggestions(0,'{$usersKeywords['Message']}','{$name}' ,'{$usersKeywords['KeyId']}','quickrun')\" "
		  . " name=\"{$name}_{$usersKeywords['Message']}\"";
	$html .= "\n<li><a $temp >
					<img src=\"../images/forward.png\"  title=\"Peforms a Quick Search {$usersKeywords['Message']}\" alt=\"\" /></a>
				</li>";
	if ($usersKeywords['KeywordStatus'] == 'A') {
		$html .= "\n<li id=pausePlay{$newmsg}><a href=\"#{$usersKeywords['Message']}\"  onclick=\"pausePlay('{$CampaignID}','{$usersKeywords['Message']}','pause')\">
						<img src=\"../images/pause_small.png\" alt=\"\" title=\"Pause auto following conversations about {$usersKeywords['Message']}\"/></a>
						</li>";
	}
	elseif ($usersKeywords['KeywordStatus'] == 'I') {
		$html .= "\n<li id=pausePlay{$newmsg}><a href=\"#{$usersKeywords['Message']}\"  onclick=\"pausePlay('{$CampaignID}','{$usersKeywords['Message']}','start')\">
						<img src=\"../images/play_small.png\" alt=\"\" title=\"Start auto following conversations about {$usersKeywords['Message']}\"/></a>
						</li>";
	}
	$html .= "\n<li><a href=\"../searchFollow/groupExists.php?keyword={$usersKeywords['Message']}\"><img src=\"../images/user.png\" alt=\"\" title=\"Join the group\" /></a></li>";
	$html .= "\n<li><a href=\"#\" onclick=\"removeKey('{$CampaignID}','{$usersKeywords['Message']}')\">
						<img src=\"../images/delete.png\" title=\"Stop auto following conversations about {$usersKeywords['Message']}\" alt=\"\" /></a>
					</li>";
	$html .= "<div class=\"clear\"></div>
								</div>";
	 if(selectfollowcount($usersKeywords['UserId'],$usersKeywords['id'])> 0) { $follow =selectfollowcount($usersKeywords['UserId'],$usersKeywords['id']); } else {$follow = '0'; };
	$html .= "<div class=\"forms01\" id=\"tr{$newmsg}2\">";
	//$html .= "Followed <span id=\"followcount{$newmsg}\">{$follow}</span> interesting new people for conversations - out of up to";
	$html .= "\n<select name=\"count{$usersKeywords['KeyId']}\" id=\"count{$usersKeywords['KeyId']}\" onchange=\"changeFollowCount('count{$usersKeywords['KeyId']}','{$usersKeywords['KeyId']}','{$CampaignID}','{$usersKeywords['UserId']}')\">";
	/**
	 * select box for Follow Count
	 */
	 
	$dkPackage 			= dkGetPackagedetails($name);
	switch ($dkPackage['followLimit'])
	{
	case "Unlimited":
			for ($j = 10; $j<=50; $j+=10) {
				$html .= "\n<option value=$j";
				if($usersKeywords['FollowCount']==$j) $html .= ' selected=\"true\" ';
				$html .=">up to $j</option>";
			}
			$html .= "\n<option value=\"100\" ";
			if($usersKeywords['FollowCount']=="100") $html .= ' selected=\"true\" ';
			$html .= ">up to 100</option>";
			$html .= "\n<option value=\"200\" ";
		    if($usersKeywords['FollowCount']=="200") $html .= ' selected=\"true\" ';
			$html .= ">up to 200</option>";
			$html .= "\n<option value=\"500\" ";
		    if($usersKeywords['FollowCount']=="500") $html .= ' selected=\"true\" ';
			$html .= ">up to 500</option>";
			$html .= "\n<option value=\"1000\" ";
		    if($usersKeywords['FollowCount']=="1000") $html .= ' selected=\"true\" ';
			$html .= ">up to 1000</option>";
			$html .= "\n<option value=\"1\" ";
		    if($usersKeywords['FollowCount']=="1") $html .= ' selected=\"true\" ';
			$html .= ">unlimited</option>";
	break;
	case "unlimited":
			for ($j = 10; $j<=50; $j+=10) {
				$html .= "\n<option value=$j";
				if($usersKeywords['FollowCount']==$j) $html .= ' selected=\"true\" ';
				$html .=">up to $j</option>";
			}
			$html .= "\n<option value=\"100\" ";
			if($usersKeywords['FollowCount']=="100") $html .= ' selected=\"true\" ';
			$html .= ">up to 100</option>";
			$html .= "\n<option value=\"200\" ";
		    if($usersKeywords['FollowCount']=="200") $html .= ' selected=\"true\" ';
			$html .= ">up to 200</option>";
			$html .= "\n<option value=\"500\" ";
		    if($usersKeywords['FollowCount']=="500") $html .= ' selected=\"true\" ';
			$html .= ">up to 500</option>";
			$html .= "\n<option value=\"1000\" ";
		    if($usersKeywords['FollowCount']=="1000") $html .= ' selected=\"true\" ';
			$html .= ">up to 1000</option>";
			$html .= "\n<option value=\"1\" ";
		    if($usersKeywords['FollowCount']=="1") $html .= ' selected=\"true\" ';
			$html .= ">unlimited</option>";
	break;
	
	case 100:
			for ($j = 10; $j<=50; $j+=10) {
				$html .= "\n<option value=$j";
				if($usersKeywords['FollowCount']==$j) $html .= ' selected=\"true\" ';
				$html .=">up to $j</option>";
			}
			$html .= "\n<option value=\"100\" ";
		    if($usersKeywords['FollowCount']=="100") $html .= ' selected=\"true\" ';
			$html .= ">up to 100</option>";
	  break;
	case 200:
		   	for ($j = 10; $j<=50; $j+=10) {
				$html .= "\n<option value=$j";
				if($usersKeywords['FollowCount']==$j) $html .= ' selected=\"true\" ';
				$html .=">up to $j</option>";
			}
			$html .= "\n<option value=\"100\" ";
		    if($usersKeywords['FollowCount']=="100") $html .= ' selected=\"true\" ';
			$html .= ">up to 100</option>";
			$html .= "\n<option value=\"200\" ";
		    if($usersKeywords['FollowCount']=="200") $html .= ' selected=\"true\" ';
			$html .= ">up to 200</option>";
	  break;
	  case 500:
		   	for ($j = 10; $j<=50; $j+=10) {
				$html .= "\n<option value=$j";
				if($usersKeywords['FollowCount']==$j) $html .= ' selected=\"true\" ';
				$html .=">up to $j</option>";
			}
			$html .= "\n<option value=\"100\" ";
			if($usersKeywords['FollowCount']=="100") $html .= ' selected=\"true\" ';
			$html .= ">up to 100</option>";
			$html .= "\n<option value=\"200\" ";
		    if($usersKeywords['FollowCount']=="200") $html .= ' selected=\"true\" ';
			$html .= ">up to 200</option>";
			$html .= "\n<option value=\"500\" ";
		    if($usersKeywords['FollowCount']=="500") $html .= ' selected=\"true\" ';
			$html .= ">up to 500</option>";
	  break;
	  case 1000:
		    for ($j = 10; $j<=50; $j+=10) {
				$html .= "\n<option value=$j";
				if($usersKeywords['FollowCount']==$j) $html .= ' selected=\"true\" ';
				$html .=">up to $j</option>";
			}
			$html .= "\n<option value=\"100\" ";
			if($usersKeywords['FollowCount']=="100") $html .= ' selected=\"true\" ';
			$html .= ">up to 100</option>";
			
			$html .= "\n<option value=\"200\" ";
		    if($usersKeywords['FollowCount']=="200") $html .= ' selected=\"true\" ';
			$html .= ">up to 200</option>";
			$html .= "\n<option value=\"500\" ";
		    if($usersKeywords['FollowCount']=="500") $html .= ' selected=\"true\" ';
			$html .= ">up to 500</option>";
			$html .= "\n<option value=\"1000\" ";
		    if($usersKeywords['FollowCount']=="1000") $html .= ' selected=\"true\" ';
			$html .= ">up to 1000</option>";
	  break;
	default:
	 		for ($j = 10; $j<=$dkPackage['followLimit']; $j++) {
				$html .= "\n<option value=$j";
				if($usersKeywords['FollowCount']==$j) $html .= ' selected=\"true\" ';
				$html .=">up to $j</option>";
			}
	 }
	$html .= '\n</select> people. <br/><br/>';
	
$nc_checked 	= '';	
$s_day 			= '';	
$s_week 		= '';	
$s_month 		= '';	
if($usersKeywords['notify_status'] == 'yes') $nc_checked 	= ' checked="checked" ';	
if($usersKeywords['notify_frequency]'] == 'day') $s_day 	= ' selected="selected" ';	
if($usersKeywords['notify_frequency]'] == 'week') $s_week 	= ' selected="selected" ';	
if($usersKeywords['notify_frequency]'] == 'month') $s_month	= ' selected="selected" ';	
$html .= '
<input type="checkbox" '.$nc_checked.' id="notify_checkbox_'.$usersKeywords['id'].'" onclick="dkRegisterKeywordNotification(this,\''.$name.'\',\''.$usersKeywords['id'].'\')"  />
 Notify me every 			
<select id ="notify_frequency_'.$usersKeywords['id'].'"  class="inner_option_medium" onchange="dkChangeNotifyFrequency(\''.$name.'\',\''.$usersKeywords['id'].'\')">
	<option '.$s_day.' value="day">Every Day</option>
	<option '.$s_week.' value="week">Every Week</option>
	<option '.$s_month.' value="month">Every Month</option>
</select>
 new suggestions

	</div>';
	
//-------------------dk---------------------------------------------------------------------------------	
	$html .= "\n<div class=\"forms01\" id=\"tr{$newmsg}3\">";
	$suggestions = dkGetSuggestionsUserListCount($name,$usersKeywords['KeyId']);
	if($suggestions>0)
	{
		$temp = " href=\"#{$usersKeywords['KeyId']}\" "
			  . " onclick=\"dkListSuggestions(0,'{$usersKeywords['Message']}','{$name}' ,'{$usersKeywords['KeyId']}','suggest')\" "
			  . " name=\"{$name}_{$usersKeywords['Message']}\"";
		$html .= '<strong  ><a '.$temp.' >Suggestions('.$suggestions.')</a>&nbsp;|&nbsp;</strong>';
	}
	else
	{
		$html .= '<strong  >Suggestions('.$suggestions.')&nbsp;|&nbsp;</strong>';
	}
	$queued = dkGetQueuedUserListCount($name,$usersKeywords['KeyId']);
	if($queued>0)
	{
		$temp = " href=\"#{$usersKeywords['KeyId']}\" "
			  . " onclick=\"dkListQueued(0,'{$usersKeywords['Message']}','{$name}' ,'{$usersKeywords['KeyId']}','queued')\" "
			  . " name=\"{$name}_{$usersKeywords['Message']}\"";
		$html .= '<strong  ><a '.$temp.' >Queued('.$queued.')</a>&nbsp;|&nbsp;</strong>';
	}
	else
	{
		$html .= '<strong  >Queued('.$queued.')&nbsp;|&nbsp;</strong>';
	}
	$followed = dkGetFollowedUserListCount($name,$usersKeywords['KeyId']);
	if($followed>0)
	{
		$temp = " href=\"#{$usersKeywords['KeyId']}\" "
			  . " onclick=\"dkListFollowed(0,'{$usersKeywords['Message']}','{$name}' ,'{$usersKeywords['KeyId']}','followed')\" "
			  . " name=\"{$name}_{$usersKeywords['Message']}\"";
		$html .= '<strong  ><a '.$temp.' >Followed('.$followed.')</a>&nbsp;|&nbsp;</strong>';
	}
	else
	{
		$html .= '<strong  >Followed('.$followed.')&nbsp;|&nbsp;</strong>';
	}
	$blocked = dkGetBlockUserListCount($name,$usersKeywords['KeyId']);
	if($blocked>0)
	{
		$temp = " href=\"#{$usersKeywords['KeyId']}\" "
			  . " onclick=\"dkListBlocked(0,'{$usersKeywords['Message']}','{$name}' ,'{$usersKeywords['KeyId']}','blocked')\" "
			  . " name=\"{$name}_{$usersKeywords['Message']}\"";
		$html .= '<strong  ><a '.$temp.' >Blocked('.$blocked.')</a></strong>';
	}
	else
	{
		$html .= '<strong  >Blocked('.$blocked.')</strong>';
	}
	$html .= "</div>";
	
//-------------------dk---------------------------------------------------------------------------------	
	
	
	
	$html .= "\n<!-- Followers Area Start -->";
	$html .= "\n<div class=\"editaccounts\" id=\"tr{$newmsg}4\">";
	$html .= "<span id=\"{$newmsg}_following\"></span></div></td></tr>";
	return $html;
}
function setToArray($results, & $keywordMessages) {
	$resultCount=count($results);
	for ($i = 0; $i < $resultCount; $i++) {
		$result = $results[$i];
		$keywordMessage['profile_image_url'] = $result[profile_image_url];
		$keywordMessage['from_user'] = $result[from_user];
		$keywordMessage['created_at'] = strtotime($result[created_at]);
		$keywordMessage['profile_image_url'] = $result[profile_image_url];
		$keywordMessage['text'] = $result[text];
		array_push($keywordMessages, $keywordMessage);
	}
}
function toLink($text) {
	$text = html_entity_decode($text);
	$text = " " . $text;
	$text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="\\1">\\1</a>', $text);
	$text = eregi_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="\\1">\\1</a>', $text);
	$text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\\1<a href="http://\\2">\\2</a>', $text);
	$text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})', '<a href="mailto:\\1">\\1</a>', $text);
	return $text;
}
?>
