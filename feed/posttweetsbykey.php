<?php
 
$getCronFiles = getFeeds();
$xmlDoc = new DOMDocument();
//$arrCount=count($getCronFiles);




 $arrCount=count($getCronFiles);
 
$rssTweets=array();
//for ($i = 0; $i < $arrCount; $i++) {

$rss_feed = simplexml_load_file($Getfeeddetailsbyuserid[$p]["feedurl"]);
 for ($i = 0; $i < 1; $i++) {
 
 foreach( $rss_feed->channel->item as $item ) {
 
 
 if($Getfeeddetailsbyuserid[$p]["sortid"] == 1)
 {
 
    	$itemRSS = array (
		'title' => $item->title,
		'link' => $item->link,
		'desc' => $item->description,
		'date' => $item->pubDate,
		'tweet'=>''
		);
	
		}
		 if($Getfeeddetailsbyuserid[$p]["sortid"] == 2)
 {
 
    	$itemRSS = array (
		'title' => $item->title,
		'link' => $item->link,
		'desc' => $item->description,
		'guid' => $item->guid,
		'tweet'=>''
		);
		}
		
 
 
		
		
		if($itemRSS['title']==""){
		$itemRSS['title']=$item->language;
	}
	if($getCronFiles[$i]['showdesc']==0){
		$tweet=$itemRSS['title'];
	}elseif($getCronFiles[$i]['showdesc']==1){
		$tweet=$itemRSS['title'] . " ". $itemRSS['desc'];
	}else{
		$tweet=$itemRSS['desc'];
	}
	if (strlen($tweet) > 140) {
			$tweet = substr($tweet, 0, 136) . "....";
		}
	$itemRSS['tweet']=$tweet;
	array_push($rssTweets, $itemRSS);
	
	 
	
}
}

echo "<pre>";
print_r($rssTweets);
echo "</pre>";
exit;

//}
 
 


	// print  $rssTweets[$i]["tweet"][0];
 // exit;
	

	// Checking And insertng the Feed Records by PUB DATE , GUID 
	
	
	for($i=0;$i<count($rssTweets);$i++)
	{
	 
	 
	// Checking And insertng the Feed Records by PUB DATE , GUID 
 if($Getfeeddetailsbyuserid[$p]["sortid"] == 1)
 {
 
 //Chec l already  exists 
 $pd = $rssTweets[$i]["date"];
 $checlalreadyexist = "SELECT count(*) from ta_feed_results WHERE Username ='$UserName' && Pubdate='$pd'";
  $checlalreadyexistresult  = runQuery($checlalreadyexist);
  if($checlalreadyexistresult[0][0] ==0){
//  print  $rssTweets[$i]["tweet"][0];
 // exit;
 $insertfeedresultsbypubid = "INSERT INTO  `ta_feed_results` ( `Username` ,`Pubdate` ,`GUID`)VALUES ('$UserName','$pd','')";
 $insertfeedresultsbypubidok = runQuery($insertfeedresultsbypubid);
 include "posttweets.php";
 }
 
 
 }
 
  if($Getfeeddetailsbyuserid[$p]["sortid"] == 2)
 {
  $pd = $rssTweets[$i]["guid"];
 $checlalreadyexist = "SELECT count(*) from ta_feed_results WHERE Username ='$UserName' && GUID='$pd'";
  $checlalreadyexistresult  = runQuery($checlalreadyexist);
  if($checlalreadyexistresult[0][0] ==0){
 $insertfeedresultsbyguid = "INSERT INTO  `ta_feed_results` ( `Username` ,`Pubdate` ,`GUID`)VALUES ('$UserName','','$pd')";
  $insertfeedresultsbyguidok = runQuery($insertfeedresultsbyguid);
   include "posttweets.php";
  }
  
 }
 // Checking And insertng the Feed Records by PUB DATE , GUID 
 
	
	 
	}
	
	
	
	

?>