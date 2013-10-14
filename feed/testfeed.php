<?PHP  
  $BLOGURL = "http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/front_page/rss.xml"; 
  $NUMITEMS = 2; 
  $TIMEFORMAT = "j F Y, g:ia"; 
  $CACHEFILE = md5($BLOGURL); 
  $CACHETIME = 4; 
  
  
  
   if(!file_exists($CACHEFILE) || ((time() - filemtime($CACHEFILE)) > 3600 * $CACHETIME)) { 
   if($feed_contents = file_get_contents($BLOGURL)) { 
    $fp = fopen($CACHEFILE, 'w'); 
	fwrite($fp, $feed_contents);
	 fclose($fp); } } 
	
	
	
	
	
	include "class.myrssparser.php"; 
	$rss_parser = new myRSSParser($CACHEFILE);
	
	
	
	//  $feeddata = $rss_parser->getRawOutput(); 
	 // extract($feeddata['RSS']['CHANNEL'][0], EXTR_PREFIX_ALL, 'rss'); 
	  
	  
	  // extract($rss_IMAGE[0], EXTR_PREFIX_ALL, 'img'); 	   
	  // echo "<p><a title=\"{$img_TITLE}\" href=\"{$img_LINK}\"><img src=\"{$img_URL}\" alt=\"\"></a></p>\n"; 
	   
	   
	    // echo "<h4><a title=\"",htmlspecialchars($rss_DESCRIPTION),"\" href=\"{$rss_LINK}\" target=\"_blank\">"; 
		// echo htmlspecialchars($rss_TITLE); 
		// echo "</a></h4>\n";
		 
		 
		   $count = 0; 
		   foreach($rss_ITEM as $itemdata) { 
		   echo "<p><b><a href=\"{$itemdata['LINK']}\" target=\"_blank\">"; 
		   echo htmlspecialchars(stripslashes($itemdata['TITLE'])); 
		   echo "</a></b><br>\n"; 
		   echo htmlspecialchars(stripslashes($itemdata['DESCRIPTION'])),"<br>\n"; 
		   echo "<i>",date($TIMEFORMAT, strtotime($itemdata['PUBDATE'])),"</i></p>\n\n"; if(++$count >= $NUMITEMS) 
		   break;
		   
		    } 
		   
		     echo "<p><small>&copy; {",htmlspecialchars($rss_COPYRIGHT),"}</small></p>\n";
			 
			 
			  ?>