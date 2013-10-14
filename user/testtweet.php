<?php
define("SECOND", 1);
define("MINUTE", 60 * SECOND);
define("HOUR", 60 * MINUTE);
define("DAY", 24 * HOUR);
define("MONTH", 30 * DAY); 
include ('../classes/class.twitter.php');
include ('../common/commonfunctions.php');
$user="divyatjoseph";
$secret="divya1";
$summize = new summize($user, $secret);
$gettweet = $summize->userTimeline($user,$count=3,$since=false,$since_id=false,$page=false);
$result=objectToArray($gettweet);
//print_r($result);
for($i=0;$i<count($result);$i++)
{
	$created =$result[$i]['created_at'];
     // Thu May 06 09:28:27
    $newdstr=substr($created, 0, 19); 
    //echo "twitter time". $newdstr;
    $newdstr= date('Y-m-d H:i:s',strtotime($newdstr));
    $newdstr2= date("Y-m-d H:i:s", mktime(date('H',strtotime($newdstr))+3, date('i',strtotime($newdstr)), date('s',strtotime($newdstr)), date('m',strtotime($newdstr)), date('d',strtotime($newdstr)), date('Y',strtotime($newdstr))));
    echo $re= getTimeDifference($newdstr2,$curdate)."\n";
       //echo time_since($re);date('m',strtotime($resu
      
}
function getTimeDifference($date1,$date2)
  {
   $unix_date1 = strtotime($date1);
   $unix_date2 = strtotime($date2);   
   $difference =  $unix_date2 - $unix_date1;
   $hours   =  floor($difference/(60*60));
   $remain   =  ceil($difference%(60*60));
   $mins    =  floor($remain/60); 
   $sec    =  floor($remain/60);
   $tim_dur=$date1;
  // if($hours<24)
  //{
   if($hours>0)
   {
   	  $tim_dur = "about $hours hour ago";
   }
  else if($mins>0)
   {
   	  $tim_dur = "about $mins minutes  ago";
   }
  else if($sec>0)
   {
    	  $tim_dur = "about $sec seconds  ago";
   }
  //}
return $tim_dur;  
    }   
function time_since($secs)
    {
        $days = round($secs / 86400);
        ($days == 1) ? $days_word = 'day' : $days_word = 'days';

        $hours = round($secs / 3600);
        ($hours == 1) ? $hours_word = 'hour' : $hours_word = 'hours';
		//echo "hours".$hours; 
        $minutes = round($secs / 60);
        //echo "min".$minutes; 
        ($minutes == 1) ? $minutes_word = 'minute' : $minutes_word = 'minutes';

        $seconds = $secs;

        if($days > 0)
        {
            $since = $days .' '.$days_word;

        } elseif($hours > 0)
        {
            $since = 'About '.$hours.' '.$hours_word;
        } elseif($minutes > 0)
        {
            $since = 'About '.$minutes.' '.$minutes_word;
        } else {
            $since = 'About '.$secs.' seconds';
        }

        return $secs;
    }

function relativeTime($time)
	{
	    $delta = strtotime('+2 hours') - $time;
	    if ($delta < 2 * MINUTE) {
        return "1 min ago";
	    }
	    if ($delta < 45 * MINUTE) {
	        return floor($delta / MINUTE) . " min ago";
	    }
	    if ($delta < 90 * MINUTE) {
	        return "1 hour ago";
	    }
	    if ($delta < 24 * HOUR) {
	        return floor($delta / HOUR) . " hours ago";
	    }
	    if ($delta < 48 * HOUR) {
	        return "yesterday";
	    }
    if ($delta < 30 * DAY) {
	        return floor($delta / DAY) . " days ago";
    }
	    if ($delta < 12 * MONTH) {
	        $months = floor($delta / DAY / 30);
	        return $months <= 1 ? "1 month ago" : $months . " months ago";
	    } else {
	        $years = floor($delta / DAY / 365);
	        return $years <= 1 ? "1 year ago" : $years . " years ago";
	    }
	}
?>