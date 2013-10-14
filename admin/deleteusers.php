<?php 

include "configoriginal.php";


$ciduuu = $_REQUEST["d"];

// delete tables related campaign 

//$deletecampaignquery = "DELETE   FROM ta_users WHERE    	UserID='$ciduuu'";
$deletecampaignquery = " DELETE a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,j.*,k.*,m.*,p.*,q.*,r.*,s.* FROM `ta_users` a LEFT JOIN `ta_user_subscriptions` b ON a.`UserName` = b.`UserName` LEFT JOIN `ta_user_keys` c ON a.`UserName` = c.`Username` LEFT JOIN `ta_group_member_profile` d ON a.`UserName` = d.`memberName` LEFT JOIN `ta_group_members` e ON a.`UserName` = e.`memberName`  LEFT JOIN `ta_group` f ON a.`UserName` = f.`groupOwner` LEFT JOIN `ta_group` g ON a.`UserName` = g.`groupOwner`  LEFT JOIN `ta_mass_follow` h ON a.`UserName` = h.`followfrom`  LEFT JOIN `ta_group_follow` j ON a.`UserName` =j.`userfollow` LEFT JOIN `ta_follow_blocked_user_list` k ON a.`UserName` = k.`user_name`  LEFT JOIN `ta_follow_queued_user_list` m ON a.`UserName` = m.`user_name` LEFT JOIN `ta_affiliate_request` p ON a.`UserName` = p.`UserID` LEFT JOIN  `ta_automated_unfollow_log` q ON a.`UserID`=q.`user_id` LEFT JOIN  `ta_automated_unfollow_queue` r ON a.`UserID`=r.`user_id` LEFT JOIN `ta_automated_unfollow_settings` s ON a.`UserID`=s.`user_id` WHERE a.`UserID`='$ciduuu' "; 
mysql_query($deletecampaignquery);

$deletekeywrdusers = "DELETE a.*  FROM `ta_keyword_users` a  WHERE a.UserId='$ciduuu'";
mysql_query($deletekeywrdusers);

$getallcampaigns ="SELECT * FROM  ta_campaigns";
$getallcampaignsquery = mysql_query($getallcampaigns);
while($getallcampaignsqueryresult = mysql_fetch_array($getallcampaignsquery)){
	  $cid = $getallcampaignsqueryresult[CampaignID];
	  $userid = $getallcampaignsqueryresult[UserID];
	  if($userid != ""){
		$splituserid = explode("-",$userid);
		$k=0;
		for($p=0;$p<count($splituserid);$p++){
		     if($splituserid[$p] != ""){
			$originalarray[$k] = $splituserid[$p];
			$k++;
			}		
		}
		if(count($originalarray) >1){
		if(in_array($ciduuu,$originalarray)){
			//remove selected userid from table 
			$m = 0;
			for($h=0;$h<count($originalarray);$h++)
			{
				if($originalarray[$h] != $ciduuu)
				{
					$updatearray[$m] =$originalarray[$h];
					 $m++;
				}
			}
			//join userid'd 
			$juserids = join("-",$updatearray);
			//$updatecampaigntable = "UPDATE `ta_campaigns` SET `UserID` = '$juserids' WHERE  `CampaignID` ='$cid'";
			//mysql_query($updatecampaigntable);
		}
		}
		else
		{
		if($ciduuu == $originalarray[0]){
	 $deletewithcampidquery = " DELETE a.*,b.*,c.*,d.*,e.*,f.*,g.*  FROM `ta_feed_results` a LEFT JOIN `ta_feeds` b ON a.`CampaignID` = b.`CampaignID` LEFT JOIN `ta_future_tweet_messages` c ON a.`CampaignID` = c.`CampaignId` LEFT JOIN `ta_future_tweet_messages_status` d ON a.`CampaignID` = d.`CampaignId` LEFT JOIN `ta_save_tweets` e ON a.`CampaignID` = e.`CampaignID`  LEFT JOIN `ta_save_tweets_settings` f ON a.`CampaignID` = f.`CampaignID`  LEFT JOIN `ta_category_tweet_messages_settings` g ON a.`CampaignID` = g.`CampaignId` WHERE a.`CampaignID`='$cid' "; 
		mysql_query($deletewithcampidquery);

		 //delete campaign row completely 
		$deletecampaignquery123 = "DELETE   FROM ta_campaigns WHERE  	CampaignID='$cid'";
		mysql_query($deletecampaignquery123);
				}	
		}
	}
}
echo "deleted";

