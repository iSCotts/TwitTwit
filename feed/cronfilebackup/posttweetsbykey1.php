<?php
 
$getCronFiles = getFeeds();
$xmlDoc = new DOMDocument();
//$arrCount=count($getCronFiles);




 $arrCount=count($getCronFiles);
 
$rssTweets=array();
//for ($i = 0; $i < $arrCount; $i++) {

$rss_feed = simplexml_load_file($Getfeeddetailsbyuserid[$p]["feedurl"]);


$tvalue =0;
 foreach( $rss_feed->channel->item as $itemtest ) {
$tvalue = $tvalue+1;

 }
 
 
 for ($i = 0; $i < 1; $i++) {
 $xmlDoc->load($Getfeeddetailsbyuserid[$p]["feedurl"]);
 
 $x = $xmlDoc->getElementsByTagName('item');
 for($j=0;$j<$tvalue;$j++) {
 
 
 if($Getfeeddetailsbyuserid[$p]["sortid"] == 1)
 {
 
    	$itemRSS = array (
		'title' => $x->item($j)->getElementsByTagName('title')->item(0)->nodeValue,
		'link' => $x->item($j)->getElementsByTagName('link')->item(0)->nodeValue,
		'desc' => $x->item($j)->getElementsByTagName('description')->item(0)->nodeValue,
		'date' => $x->item($j)->getElementsByTagName('pubDate')->item(0)->nodeValue,
		'tweet'=>''
		);
	
		}
		 if($Getfeeddetailsbyuserid[$p]["sortid"] == 2)
 {
 
 
 $itemRSS = array (
		'title' => $x->item($j)->getElementsByTagName('title')->item(0)->nodeValue,
		'link' => $x->item($j)->getElementsByTagName('link')->item(0)->nodeValue,
		'desc' => $x->item($j)->getElementsByTagName('description')->item(0)->nodeValue,
		'guid' => $x->item($j)->getElementsByTagName('guid')->item(0)->nodeValue,
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

//echo "<pre>";
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