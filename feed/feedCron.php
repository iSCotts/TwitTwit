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

 
 

	  $xmlDoc->load($getCronFiles[$i]['feedurl']);

 
   
for ($j = 1; $j >1; ) {
 

	$x = $xmlDoc->getElementsByTagName('item');
	
	
	$itemRSS = array (
		'lang'=>$x->item($j)->getElementsByTagName('language')->item(0)->nodeValue,
		'title' => $x->item($j)->getElementsByTagName('title')->item(0)->nodeValue,
		'link' => $x->item($j)->getElementsByTagName('link')->item(0)->nodeValue,
		'desc' => $x->item($j)->getElementsByTagName('description')->item(0)->nodeValue,
		'date' => $x->item($j)->getElementsByTagName('pubDate')->item(0)->nodeValue,
		'tweet'=>''
	);
	if($itemRSS['title']==""){
		$itemRSS['title']=$xmlDoc->getElementsByTagName('language')->item(0)->nodeValue;
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
	 
	
	for($i=0;$i<count($rssTweets);$i++)
	{
	
	include "feedtotwitter.php";
	 
	}
	
	
?>
