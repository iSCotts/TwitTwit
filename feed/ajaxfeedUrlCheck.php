<?php
/*
 * Created on 29-Dec-2009
 * Author :	root
 * File:	ajaxfeedUrlCheck.php
 *
 */

require_once('FeedFinder.php');
//$aFeedFinder = FeedFinder::getInstance();
 

//if($aFeedFinder->isRss($_REQUEST['url'])){
			
	
	
	$urlregex = "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";
if (eregi($urlregex, $_REQUEST['url'])) 
{
//echo "good";

	$sFeedURL =$_REQUEST['url'];
		      $sValidator = 'http://feedvalidator.org/check.cgi?url=';
		    
		    
		    
		    
	 
		
    
			if( $sValidationResponse = @file_get_contents($sValidator . urlencode($sFeedURL)) )
			{
			//	print "<pre>";
			//	print_r($sValidationResponse);
			//	print "<pre>";
				
				
				
				if( stristr( $sValidationResponse , 'This is a valid RSS feed' ) !== false )
				{
				// print "fine";
					 
					  $sp = explode("value=",$sValidationResponse);
					  $sp1 = explode("/>",$sp[1]);
					   $sp2 = explode('"',$sp1[0]);
					 
					   
					   print "fine!".$sp2[1];
					   
					   
					  
					  
					 
					 
				}
				else
				{
				print "Your Rss feed Url Should have Unique Pubdate OR GUID,try again ";
					 
				}
			}
			else
			{
			print "Your Rss feed Url Should have Unique Pubdate OR GUID,try again ";
				 
			}
			exit;
			
			
} 


else {
	echo "We couldn't parse this feed, please check URL and/or feed content are valid";
exit;

}  


/*	$sFeedURL =$_REQUEST['url'];
		      $sValidator = 'http://feedvalidator.org/check.cgi?url=';
		    
		    
		    
		    
	 
		
    
			if( $sValidationResponse = @file_get_contents($sValidator . urlencode($sFeedURL)) )
			{
				if( stristr( $sValidationResponse , 'This is a valid RSS feed' ) !== false )
				{
				print "fine";
					 
				}
				else
				{
				print "Your Rss feed Url Should have Unique Pubdate OR GUID,try again ";
					 
				}
			}
			else
			{
			print "Your Rss feed Url Should have Unique Pubdate OR GUID,try again ";
				 
			}
			exit;*/
	
			
		//$rss_feed = simplexml_load_file($_REQUEST['url']);
		
		
		//print "<pre>";
		//print_r($rss_feed);
		//print "<pre>";
		//exit;
		
		/*foreach( $rss_feed->channel->item as $item ) {
				print "<b><a href=$item->link>$item->title</a></b><br>";
				print "$item->description<br>";
				print "<i>$item->pubDate</i><br><br>";
		}

	echo "Feed parsed OK ";
}else{
	echo "We couldn't parse this feed, please check URL and/or feed content are valid";
}*/
		
?>
