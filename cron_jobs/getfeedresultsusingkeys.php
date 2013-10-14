<?php
include_once('../common/sqlFunctions.php');
include_once('../common/dkall.php');
include_once('../common/dbconfig.php');

   include_once "../shuffle.php";
$getCronFiles = getFeeds();
$xmlDoc = new DOMDocument();
//$arrCount=count($getCronFiles);




 $arrCount=count($getCronFiles);
 
$rssTweets=array();
//for ($i = 0; $i < $arrCount; $i++) {

$rss_feed = simplexml_load_file($Getallactivefeedurlsresult[$p]["feedurl"], 'SimpleXMLElement', LIBXML_NOCDATA);


$tvalue =0;
 foreach( $rss_feed->channel->item as $itemtest ) {
$tvalue = $tvalue+1;

 }
 
 
 for ($i = 0; $i < 1; $i++) {
 $xmlDoc->load($Getallactivefeedurlsresult[$p]["feedurl"]);
 
 $x = $xmlDoc->getElementsByTagName('item');
 for($j=0;$j<$tvalue;$j++) {
 
 
 if($Getallactivefeedurlsresult[$p]["sortid"] == 1)
 {
 
    	$itemRSS = array (
		'title' => $x->item($j)->getElementsByTagName('title')->item(0)->nodeValue,
		'link' => $x->item($j)->getElementsByTagName('link')->item(0)->nodeValue,
		'desc' => $x->item($j)->getElementsByTagName('description')->item(0)->nodeValue,
		'date' => $x->item($j)->getElementsByTagName('pubDate')->item(0)->nodeValue,
		'tweet'=>''
		);
	
		}
		 if($Getallactivefeedurlsresult[$p]["sortid"] == 2)
 {
 
 
 $itemRSS = array (
		'title' => $x->item($j)->getElementsByTagName('title')->item(0)->nodeValue,
		'link' => $x->item($j)->getElementsByTagName('link')->item(0)->nodeValue,
		'desc' => $x->item($j)->getElementsByTagName('description')->item(0)->nodeValue,
		'guid' => $x->item($j)->getElementsByTagName('guid')->item(0)->nodeValue,
		'tweet'=>''
		);
		
		
    	
		}
		
 
 
				
 		/*	if($Getfeeddetailsbyuserid[$p]['showdesc']==0){
					$tweet=$itemRSS['title'];
				}elseif($Getfeeddetailsbyuserid[$p]['showdesc']==1){
					$tweet=$itemRSS['title'] . " ". $itemRSS['desc'];
				}else{
					$tweet=$itemRSS['desc'];
				}
				
				*/
		
		
	/* 	if($itemRSS['title']==""){
		$itemRSS['title']=$item->language;
	}
	if($getCronFiles[$i]['showdesc']==0){
		$tweet=$itemRSS['title'];
	}elseif($getCronFiles[$i]['showdesc']==1){
		$tweet=$itemRSS['title'] . " ". $itemRSS['desc'];
	}else{
		$tweet=$itemRSS['desc'];
	} */
		
		
	
				
			// new code for formatting title,desc and both 
				
 				if($Getallactivefeedurlsresult[$p]['showdesc']==0  && $Getallactivefeedurlsresult[$p]["posturl"] != 1){
					$tweet=$itemRSS['title'];
				}
				if($Getallactivefeedurlsresult[$p]['showdesc']==0  && $Getallactivefeedurlsresult[$p]["posturl"] == 1){
					$tweet=$itemRSS['title']." ";
				}
				if($Getallactivefeedurlsresult[$p]['showdesc']==1  && $Getallactivefeedurlsresult[$p]["posturl"] != 1){
					$tweet=$itemRSS['title'] . ":". $itemRSS['desc'];
				}
				if($Getallactivefeedurlsresult[$p]['showdesc']==1  && $Getallactivefeedurlsresult[$p]["posturl"] == 1){
					$tweet=$itemRSS['title'] . ":". $itemRSS['desc']." ";
				}
 				if($Getallactivefeedurlsresult[$p]['showdesc']==2 && $Getallactivefeedurlsresult[$p]["posturl"] != 1){
					$tweet=$itemRSS['desc'];
					
				}
 				if($Getallactivefeedurlsresult[$p]['showdesc']==2  && $Getallactivefeedurlsresult[$p]["posturl"] == 1){
					$tweet=$itemRSS['desc']." ";
					
				}
				// new code for formatting title,desc and both 
				
				
				
	
			// Concat with POST URL 
			/*	if($Getfeeddetailsbyuserid[$p][posturl] == 1){
					
					if($Getfeeddetailsbyuserid[$p][shorturl]  ==1 ){
				 $posturlstatus =1;
			  	 $url = geturl($itemRSS['link']);				 
				  $tweeturl =$url;
					}
					
					else
					{
						
				 			 
				  $tweeturl =$itemRSS['link'];
					}
					
					
					 $gettweetposturllength = strlen($tweeturl);
				  
				  $givechartoothers = (130 - $gettweetposturllength);
				  
				  $dotschars =($givechartoothers -4);

			 
					
				if (strlen($tweet) > $dotschars) {
						$tweet = substr($tweet, 0, $dotschars) . "....";
					}
					
					
				$lessthanvalue = $dotschars+4;
				
					if (strlen($tweet) < $lessthanvalue) {
						$tweet = substr($tweet, 0, $lessthanvalue);
				}
				
				
					
					$originaltweetmessage = $tweet.$tweeturl;
					$tweet= $originaltweetmessage;
					
				 
				}
				
					else
				{
				if (strlen($tweet) > 130) {
						$tweet = substr($tweet, 0, 136) . "....";
					}
					
				}
				*/
				
				
				
				// Concat with POST URL 
				
				
	//if (strlen($tweet) > 140) {
		//	$tweet = substr($tweet, 0, 136) . "....";
		//}
	$itemRSS['tweet']=$tweet;
	array_push($rssTweets, $itemRSS);
	
	 
	
}
}

////echo "<pre>";
//print_r($rssTweets);
//echo "</pre>";
//exit;

//}
 
 


	// print  $rssTweets[$i]["tweet"][0];
 // exit;
	

	// Checking And insertng the Feed Records by PUB DATE , GUID 
	
	
	for($i=0;$i<count($rssTweets);$i++)
	{
	 
	 
	// Checking And insertng the Feed Records by PUB DATE , GUID 
 if($Getallactivefeedurlsresult[$p]["sortid"] == 1)
 {
 
 //Chec l already  exists 
 $pd = $rssTweets[$i]["date"];
 $checlalreadyexist = "SELECT count(*) from ta_feed_results WHERE CampaignID ='$CampaignID' &&  Username ='$Username' && Pubdate='$pd'";
  $checlalreadyexistresult  = runQuery($checlalreadyexist);
  if($checlalreadyexistresult[0][0] ==0){
//  print  $rssTweets[$i]["tweet"][0];
 // exit;
 
  	
  				// Concat with POST URL starts here 
				if($Getallactivefeedurlsresult[$p]["posturl"] == 1){
										
					if($Getallactivefeedurlsresult[$p]["shorturl"] == 1){
						
						 $posturlstatus =1;
						 $url = dkGetUrl($rssTweets[$i]['link']);	
						 $tweeturl =$url;
						 $updatefeed="UPDATE ta_short_urls SET campaign_id='$CampaignID',app_type='Feed',com_id='".$Getallactivefeedurlsresult[$p]["id"]."' where CONCAT('http://twitjix.com/',short)='$url'";
						 runQuery($updatefeed);
											}
					else
					{
				  			$tweeturl =$rssTweets[$i]['link'];
					}
				 
				  $gettweetposturllength = strlen($tweeturl);				  
				  $givechartoothers = (140 - $gettweetposturllength);				  
				  $dotschars =($givechartoothers -4);		
				  		  
				    $tweetaftertrim = strip_tags($rssTweets[$i]['tweet']);
				    
				    
						if (strlen($tweetaftertrim) > $dotschars) {
						$tweet = substr($tweetaftertrim, 0, $dotschars) . "....";
						}
					
						$lessthanvalue = $dotschars+4;
				
						if (strlen($tweetaftertrim) < $lessthanvalue) {
						$tweet = substr($tweetaftertrim, 0, $lessthanvalue);
						}
				
					$originaltweetmessage = $tweet.$tweeturl;
					$tweet= $originaltweetmessage;
					
					
				}
				else
				{
				if (strlen($rssTweets[$i]['tweet']) > 140) {
					$tweet = strip_tags($rssTweets[$i]['tweet']);					
					
						$tweet = substr($tweet, 0, 136) . "....";
					 
						
					}					
				}				
				
				 $rssTweets[$i]['tweet'] = $tweet;
				//exit;
				
				
				// Concat with POST URL Ends Here 
				
				 
				 
  	 //Get Feed Id for store feed results 
 
  //	$getfeedIdforstorefeedresults = "SELECT * FROM ta_feeds WHERE UserID='$UserName' AND feedurl='$_REQUEST[feedurl]'";
  //	$getfeedIdforstorefeedresults  = runQuery($getfeedIdforstorefeedresults);
    $feedid = $Getallactivefeedurlsresult[$p]["id"];
  //Get Feed Id for store feed results 
  
    
    
 $phpdate = date('Y-m-d H:i:s');
include "finaltweetpostusingkeys.php";
 $insertfeedresultsbypubid = "INSERT INTO  `ta_feed_results` ( `CampaignID`,`Username`,`feedid` ,`Pubdate` ,`GUID`,`DT`)VALUES ('$CampaignID','$Username','$feedid','$pd','','$phpdate')";
 $insertfeedresultsbypubidok = runQuery($insertfeedresultsbypubid);
 
 break;
 }
 
 
 }
 
  if($Getallactivefeedurlsresult[$p]["sortid"] == 2)
 {
  $pd = $rssTweets[$i]["guid"];
 $checlalreadyexist = "SELECT count(*) from ta_feed_results WHERE CampaignID ='$CampaignID' &&  Username ='$Username' && GUID='$pd'";
  $checlalreadyexistresult  = runQuery($checlalreadyexist);
  if($checlalreadyexistresult[0][0] ==0){
  	
  	$phpdate = date('Y-m-d H:i:s');
  	
  	
  	
  		// Concat with POST URL starts here 
				if($Getallactivefeedurlsresult[$p]["posturl"] == 1){
										
					if($Getallactivefeedurlsresult[$p]["shorturl"] == 1){
						
						 $posturlstatus =1;
					  	// $url = geturl($rssTweets[$i]['link']);		
						$url = dkGetUrl($rssTweets[$i]['link']);	
								 
						 $tweeturl =$url;
						 $updatefeed="UPDATE ta_short_urls SET campaign_id='$CampaignID',app_type='Feed',com_id='".$Getallactivefeedurlsresult[$p]["id"]."' where CONCAT('http://twitjix.com/',short)='$url'";
						 runQuery($updatefeed);
											}
					
					else
					{
				  			$tweeturl =$rssTweets[$i]['link'];
					}
				 
				  $gettweetposturllength = strlen($tweeturl);				  
				  $givechartoothers = (140 - $gettweetposturllength);				  
				  $dotschars =($givechartoothers -4);		
				  		  
				  
				   $tweetaftertrim = strip_tags($rssTweets[$i]['tweet']);
				   
				   
				   
						if (strlen($tweetaftertrim) > $dotschars) {
						$tweet = substr($tweetaftertrim, 0, $dotschars) . "....";
						}
					
						$lessthanvalue = $dotschars+4;
				
						if (strlen($tweetaftertrim) < $lessthanvalue) {
						$tweet = substr($tweetaftertrim, 0, $lessthanvalue);
						}
				
					$originaltweetmessage = $tweet.$tweeturl;
					$tweet= $originaltweetmessage;
					
					
				}
				else
				{
				if (strlen($rssTweets[$i]['tweet']) > 140) {
						$tweet = strip_tags($rssTweets[$i]['tweet']);					
					
						$tweet = substr($tweet, 0, 136) . "....";
						
					}					
				}				
				
				 $rssTweets[$i]['tweet'] = $tweet;
				//exit;
				
				
				// Concat with POST URL Ends Here 
				
				 
				 
				 
  	 //Get Feed Id for store feed results 
 
  //	$getfeedIdforstorefeedresults = "SELECT * FROM ta_feeds WHERE UserID='$UserName' AND feedurl='$_REQUEST[feedurl]'";
  //	$getfeedIdforstorefeedresults  = runQuery($getfeedIdforstorefeedresults);
    $feedid = $Getallactivefeedurlsresult[$p]["id"];
  //Get Feed Id for store feed results 
  
    
  	include "finaltweetpostusingkeys.php";
 $insertfeedresultsbyguid = "INSERT INTO  `ta_feed_results` ( `CampaignID`,`Username`,`feedid` ,`Pubdate` ,`GUID`,`DT`)VALUES ('$CampaignID','$Username','$feedid','','$pd','$phpdate')";
  $insertfeedresultsbyguidok = runQuery($insertfeedresultsbyguid);
   
   break;
  }
  
 }
 // Checking And insertng the Feed Records by PUB DATE , GUID 
 
	
	 
	}
	
	
	
	

?>