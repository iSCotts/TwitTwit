<?php
ob_start();
/*
 * Created on 29-Dec-2009
 * Author :	Liju
 * File:	feedCron.php
 *
 */
include '../classes/dbClient.php';
include '../common/sqlFunctions.php';
/**
 * Setting the time slot
 */
$freq_code = round((time() - mktime(0, 0, 0, date('m'), date('d'), date('Y'))) / (60 * 60), 0);
/**
 * getting feed data from database
 */
$getCronFiles = getFeeds();

/**
 * Getting feeds from the url and save it to array $rssTweets
 * return @var $rssTweets
 *
 */
$xmlDoc = new DOMDocument();
 

  $arrCount=count($getCronFiles);
$rssTweets=array();
for ($i = 0; $i < $arrCount; $i++) {

 
 
 
$rss_feed = simplexml_load_file( $getCronFiles[$i]['feedurl'] );
 
 
 foreach( $rss_feed->channel->item as $item ) {
      //  print "<b><a href=$item->link>$item->title</a></b><br>";
      //  print "$item->description<br>";
       // print "<i>$item->pubDate</i><br><br>";
		/*$itemRSS = array (
		'lang'=>$item->language,
		'title' => $item->title,
		'link' => $item->link,
		'desc' => $item->description,
		'date' => $item->pubDate,
		'tweet'=>''
		);*/
		$itemRSS = array (
		'title' => $item->title,
		'link' => $item->link,
		'desc' => $item->description,
		'date' => $item->pubDate,
		'tweet'=>''
		);
		
		
		 
 
		
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
/**
 * Starting to tweets the data
 */
// echo $_SESSION['username'];
echo "<pre>";
print_r($rssTweets);
echo "</pre>";
	  exit;
	
	for($i=0;$i<count($rssTweets);$i++)
	{
	
	include "feedtotwitter.php";
	 
	}
	
	
	
	
?>




<!--<html>
<body>
<h1>RSS and PHP SimpleXML Example</h1>
<h2><?= $rss_feed->channel->title?></h2>
<?
// Loop thru all the 'items' and print information for each
foreach( $rss_feed->channel->item as $item ) {
        print "<b><a href=$item->link>$item->title</a></b><br>";
        print "$item->description<br>";
        print "<i>$item->pubDate</i><br><br>";
}
?>
</body>
</html>-->
