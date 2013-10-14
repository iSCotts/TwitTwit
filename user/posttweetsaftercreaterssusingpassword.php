<?php
session_start();
 include "../../shuffle.php";

		$rssTweets=array();
		$rss_feed = simplexml_load_file($_REQUEST["feedurl"], 'SimpleXMLElement', LIBXML_NOCDATA);
		foreach( $rss_feed->channel->item as $item ) {
 
 
			 if($_REQUEST["sortid"] == 1)
			 {
			 
			    	$itemRSS = array (
					'title' => $item->title,
					'link' => $item->link,
					'desc' => $item->description,
					'date' => $item->pubDate,
					'tweet'=>''
					);
				
					}
					 if($_REQUEST["sortid"] == 2)
			 {
			 
			    	$itemRSS = array (
					'title' => $item->title,
					'link' => $item->link,
					'desc' => $item->description,
					'guid' => $item->guid,
					'tweet'=>''
					);
			}
					
			 
			 
					
				
			
			//new code
 				/*if($_REQUEST['showdesc']==0){
					$tweet=$itemRSS['title'];
				}elseif($_REQUEST['showdesc']==1){
					$tweet=$itemRSS['title']." ".$itemRSS['desc'];
				}else{
					$tweet=$itemRSS['desc'];
				}	*/
			
			
				//new code 
			
				//old code 	
				/*	if($itemRSS['title']==""){
					$itemRSS['title']=$item->language;
				}*/
			
				/*if($_REQUEST['showdesc']==0){
					$tweet=$itemRSS['title'];
				}elseif($_REQUEST['showdesc']==1){
					$tweet=$itemRSS['title'] . " ". $itemRSS['desc'];
				}else{
					$tweet=$itemRSS['desc'];
				}*/
			
			//old code 
			
				
				
		// new code for formatting title,desc and both 
				
 				if($_REQUEST['showdesc']==0  && $_REQUEST["posturl"] != 1){
					$tweet=$itemRSS['title'];
				}
				if($_REQUEST['showdesc']==0  && $_REQUEST["posturl"] == 1){
					$tweet=$itemRSS['title']." ";
				}
				if($_REQUEST['showdesc']==1  && $_REQUEST["posturl"] != 1){
					$tweet=$itemRSS['title'] . ":". $itemRSS['desc'];
				}
				if($_REQUEST['showdesc']==1  && $_REQUEST["posturl"] == 1){
					$tweet=$itemRSS['title'] . ":". $itemRSS['desc']." ";
				}
 				if($_REQUEST['showdesc']==2 && $_REQUEST["posturl"] != 1){
					$tweet=$itemRSS['desc'];
					
				}
 				if($_REQUEST['showdesc']==2  && $_REQUEST["posturl"] == 1){
					$tweet=$itemRSS['desc']." ";
					
				}
				// new code for formatting title,desc and both 
				
				
				
				// Concat with POST URL 
			/*	if(isset($_REQUEST[posturl]) && ($_REQUEST[posturl] == 1)){
					
					
					if(isset($_REQUEST[shorturl]) && ($_REQUEST[shorturl] == 1)){
				 $posturlstatus =1;
			  	 $url = geturl($itemRSS['link']);				 
				  $tweeturl =$url;
					}
					
					else
					{
						
				 		 
				  $tweeturl  =$itemRSS['link'];
					}
					
					 $gettweetposturllength = strlen($tweeturl);
				  
				  $givechartoothers = (140 - $gettweetposturllength);
				  
				  $dotschars =($givechartoothers -4);
 
					
				if (strlen($tweet) > $dotschars) {UserID='$_SESSION[username]'
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
				if (strlen($tweet) > 140) {
						$tweet = substr($tweet, 0, 136) . "....";
					}
					
				}
				*/
				
				
				
 
				
				// Concat with POST URL 
				
				
				
				//if (strlen($tweet) > 140) {
				//		$tweet = substr($tweet, 0, 136) . "....";
				//	}
					
					
					
				$itemRSS['tweet']=$tweet;
				array_push($rssTweets, $itemRSS);
				
				 
				
			}
			
			
			
			
			
			
			
	 
	 
	// Checking And insertng the Feed Records by PUB DATE , GUID 
 if($_REQUEST["sortid"] == 1)
 {
 
 //Chec l already  exists 
 $pd = $rssTweets[0]["date"];
 $checlalreadyexist = "SELECT count(*) from ta_feed_results WHERE Username ='$_SESSION[username]' && Pubdate='$pd'";
  $checlalreadyexistresult  = runQuery($checlalreadyexist);
  if($checlalreadyexistresult[0][0] ==0){
  	 $phpdate = date('Y-m-d H:i:s');
  	 
//  print  $rssTweets[$i]["tweet"][0];
 // exit;
 
  	 // Concat with POST URL starts here 
				if(isset($_REQUEST[posturl]) && ($_REQUEST[posturl] == 1)){
					
					if(isset($_REQUEST[shorturl]) && ($_REQUEST[shorturl] == 1)){
						 $posturlstatus =1;
					  	 $url = geturl($rssTweets[0]['link']);				 
						  $tweeturl =$url;
					}
					
					else
					{
				  			$tweeturl =$rssTweets[0]['link'];
					}
				 
				  $gettweetposturllength = strlen($tweeturl);				  
				  $givechartoothers = (140 - $gettweetposturllength);				  
				  $dotschars =($givechartoothers -4);		
				  		  
				  
				   $tweetaftertrim = strip_tags($rssTweets[0]['tweet']);
				   
				   
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
				if (strlen($rssTweets[0]['tweet']) > 140) {
					$tweet = strip_tags($rssTweets[0]['tweet']);
					
						$tweet = substr($tweet, 0, 136) . "....";
					 
						
					}					
				}				
				
				 $rssTweets[0]['tweet'] = $tweet;
				//exit;
				
				
				// Concat with POST URL Ends Here 
				
				 
  //Get Feed Id for store feed results 
  
  	 
 
  	$getfeedIdforstorefeedresults = "SELECT * FROM ta_feeds WHERE CampaignID='$_REQUEST[CampaignID]' AND feedurl='$_REQUEST[feedurl]'";
  	$getfeedIdforstorefeedresults  = runQuery($getfeedIdforstorefeedresults);
    $feedid = $getfeedIdforstorefeedresults[0]["id"];
  //Get Feed Id for store feed results 
  
    
    
 $insertfeedresultsbypubid = "INSERT INTO  `ta_feed_results` ( `Username`,`feedid` ,`Pubdate` ,`GUID`,`DT`)VALUES ('$_SESSION[username]','$feedid','$pd','','$phpdate')";
 $insertfeedresultsbypubidok = runQuery($insertfeedresultsbypubid);
 include "posttweets1.php";
 }
 
 
 }
 
  if($_REQUEST["sortid"] == 2)
 {
  $pd = $rssTweets[0]["guid"];
 $checlalreadyexist = "SELECT count(*) from ta_feed_results WHERE Username ='$_SESSION[username]' && GUID='$pd'";
  $checlalreadyexistresult  = runQuery($checlalreadyexist);
  if($checlalreadyexistresult[0][0] ==0){
  	
  	 $phpdate = date('Y-m-d H:i:s');
  	 
  	 // Concat with POST URL starts here 
				if(isset($_REQUEST[posturl]) && ($_REQUEST[posturl] == 1)){
					
					if(isset($_REQUEST[shorturl]) && ($_REQUEST[shorturl] == 1)){
						 $posturlstatus =1;
					  	 $url = geturl($rssTweets[0]['link']);				 
						  $tweeturl =$url;
					}
					
					else
					{
				  			$tweeturl =$rssTweets[0]['link'];
					}
				 
				  $gettweetposturllength = strlen($tweeturl);				  
				  $givechartoothers = (140 - $gettweetposturllength);				  
				  $dotschars =($givechartoothers -4);		
				  		  
				   $tweetaftertrim = strip_tags($rssTweets[0]['tweet']);
				   
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
				if (strlen($rssTweets[0]['tweet']) > 140) {
						$tweet = strip_tags($rssTweets[0]['tweet']);
						$tweet = substr($tweet, 0, 136) . "....";
					
					}					
				}				
				
				 $rssTweets[0]['tweet'] = $tweet;
				//exit;
				
				
				// Concat with POST URL Ends Here 
				
				 
  	 
  	  //Get Feed Id for store feed results 
 
  	$getfeedIdforstorefeedresults = "SELECT * FROM ta_feeds WHERE CampaignID='$_REQUEST[CampaignID]' AND feedurl='$_REQUEST[feedurl]'";
  	$getfeedIdforstorefeedresults  = runQuery($getfeedIdforstorefeedresults);
    $feedid = $getfeedIdforstorefeedresults[0]["id"];
  //Get Feed Id for store feed results 
  
    
    
 $insertfeedresultsbyguid = "INSERT INTO  `ta_feed_results` ( `Username`,`feedid` ,`Pubdate` ,`GUID`,`DT`)VALUES ('$_SESSION[username]','$feedid','','$pd','$phpdate')";
  $insertfeedresultsbyguidok = runQuery($insertfeedresultsbyguid);
   include "posttweets1.php";
  }
  
 }
 // Checking And insertng the Feed Records by PUB DATE , GUID 
 
	
	 
 
	
	
	
	
			 
					