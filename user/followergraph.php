<?php
include_once '../common/dbconfig.php';
$monthselect=$_REQUEST['month'];
$yearselect=$_REQUEST['yearselect'];
$user=$_REQUEST['user'];
# ------- The graph values in the form of associative array
if(($monthselect==1) or ($monthselect==3) or ($monthselect==5) or ($monthselect==7) or ($monthselect==8) or ($monthselect==10)or ($monthselect==12))
{
$values=array("1" => 0,"2" => 0,"3" => 0,"4" => 0,"5" => 0,"6" => 0,"7" => 0,"8" => 0,"9" => 0,"10" => 0,"11" => 0,"12" => 0,"13" => 0,"14" => 0,
		"15" => 0,"16" => 0,"17" => 0,"18" => 0,"19" => 0,"20" => 0,"21" => 0,"22" => 0,"23" => 0,"24" => 0,"25" => 0,"26" => 0,"27" => 0,"28" => 0,
		"29" => 0,"30" => 0,"31" => 0
		);
		$followers=array("1" => 0,"2" => 0,"3" => 0,"4" => 0,"5" => 0,"6" => 0,"7" => 0,"8" => 0,"9" => 0,"10" => 0,"11" => 0,"12" => 0,"13" => 0,"14" => 0,
		"15" => 0,"16" => 0,"17" => 0,"18" => 0,"19" => 0,"20" => 0,"21" => 0,"22" => 0,"23" => 0,"24" => 0,"25" => 0,"26" => 0,"27" => 0,"28" => 0,
		"29" => 0,"30" => 0,"31" => 0
		);
	
}
if(($monthselect==4) or ($monthselect==6) or ($monthselect==9) or ($monthselect==11))
{
$values=array("1" => 0,"2" => 0,"3" => 0,"4" => 0,"5" => 0,"6" => 0,"7" => 0,"8" => 0,"9" => 0,"10" => 0,"11" => 0,"12" => 0,"13" => 0,"14" => 0,
		"15" => 0,"16" => 0,"17" => 0,"18" => 0,"19" => 0,"20" => 0,"21" => 0,"22" => 0,"23" => 0,"24" => 0,"25" => 0,"26" => 0,"27" => 0,"28" => 0,
		"29" => 0,"30" => 0
		);
		$followers=array("1" => 0,"2" => 0,"3" => 0,"4" => 0,"5" => 0,"6" => 0,"7" => 0,"8" => 0,"9" => 0,"10" => 0,"11" => 0,"12" => 0,"13" => 0,"14" => 0,
		"15" => 0,"16" => 0,"17" => 0,"18" => 0,"19" => 0,"20" => 0,"21" => 0,"22" => 0,"23" => 0,"24" => 0,"25" => 0,"26" => 0,"27" => 0,"28" => 0,
		"29" => 0,"30" => 0
		);
}
if(($monthselect==2) && (($yearselect%4)==0) &&(($yearselect%100)!=0))
{
$values=array("1" => 0,"2" => 0,"3" => 0,"4" => 0,"5" => 0,"6" => 0,"7" => 0,"8" => 0,"9" => 0,"10" => 0,"11" => 0,"12" => 0,"13" => 0,"14" => 0,
		"15" => 0,"16" => 0,"17" => 0,"18" => 0,"19" => 0,"20" => 0,"21" => 0,"22" => 0,"23" => 0,"24" => 0,"25" => 0,"26" => 0,"27" => 0,"28" => 0,"29" => 0);
$followers=array("1" => 0,"2" => 0,"3" => 0,"4" => 0,"5" => 0,"6" => 0,"7" => 0,"8" => 0,"9" => 0,"10" => 0,"11" => 0,"12" => 0,"13" => 0,"14" => 0,
		"15" => 0,"16" => 0,"17" => 0,"18" => 0,"19" => 0,"20" => 0,"21" => 0,"22" => 0,"23" => 0,"24" => 0,"25" => 0,"26" => 0,"27" => 0,"28" => 0,"29" => 0);

}
else if($monthselect==2)
{
$values=array("1" => 0,"2" => 0,"3" => 0,"4" => 0,"5" => 0,"6" => 0,"7" => 0,"8" => 0,"9" => 0,"10" => 0,"11" => 0,"12" => 0,"13" => 0,"14" => 0,
		"15" => 0,"16" => 0,"17" => 0,"18" => 0,"19" => 0,"20" => 0,"21" => 0,"22" => 0,"23" => 0,"24" => 0,"25" => 0,"26" => 0,"27" => 0,"28" => 0);
$followers=array("1" => 0,"2" => 0,"3" => 0,"4" => 0,"5" => 0,"6" => 0,"7" => 0,"8" => 0,"9" => 0,"10" => 0,"11" => 0,"12" => 0,"13" => 0,"14" => 0,
		"15" => 0,"16" => 0,"17" => 0,"18" => 0,"19" => 0,"20" => 0,"21" => 0,"22" => 0,"23" => 0,"24" => 0,"25" => 0,"26" => 0,"27" => 0,"28" => 0);

}
//print_r($values);
//$dateselect="2010-04-09";	
//$apitype="friendships/create";

$sql="SELECT DAY( `DT`) AS DAY , follower,  friends FROM ta_follower_count WHERE MONTH( `DT`)={$monthselect} and username='{$user}' and YEAR( `DT`)={$yearselect} GROUP BY DAY( `DT` )";	
//$sql ="SELECT apitype,DT FROM `ta_api_statistics` WHERE apitype = '{$apitype}' and DATE_FORMAT(DT, '%Y-%m-%d') = '{$dateselect}'";
db_connect();
$statCount = @mysql_query($sql);
//$statCount = runQuery($sql);
//$statCount = mysql_fetch_array($statCount);
//echo $statCount[0]['HOUR'];
//exit;
//$values=array();
$num_rows = mysql_num_rows($statCount);
db_close();
//if($num_rows>0){
while ($row = mysql_fetch_array($statCount)) {
	$day=$row['DAY'];
	//$curhour=explode(":",$hours);
	$friendscnt=$row['friends'];
    $followercnt=$row['follower'];
	//$ehour=$curhour[0];
	$values[$day]=$friendscnt;
	$followers[$day]=$followercnt;
   }
	//print_r($values);
	// exit;
 
	$img_width=700;
	$img_height=300; 
	$margins=30;

 
	# ---- Find the size of graph by substracting the size of borders
	$graph_width=$img_width - $margins * 2;
	$graph_height=$img_height - $margins * 2; 
	$img=imagecreate($img_width,$img_height);

 
	$bar_width=10;
	$total_bars=count($values);
	$gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1);
	//$gap = 0;
 
	# -------  Define Colors ----------------
	$bar_color2=imagecolorallocate($img,228,100,3);
	$bar_color=imagecolorallocate($img,0,64,128);
	$background_color=imagecolorallocate($img,240,240,255);
	$border_color=imagecolorallocate($img,200,200,200);
	$line_color=imagecolorallocate($img,220,220,220);
 
	# ------ Create the border around the graph ------

	imagefilledrectangle($img,1,1,$img_width-2,$img_height-2,$border_color);
	imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);

 
	# ------- Max value is required to adjust the scale	-------
	$max_value=max($values);
	if($max_value>0)
	{
	$ratio= $graph_height/$max_value;
}
 
	# -------- Create scale and draw horizontal lines  --------
	$horizontal_lines=$max_value;
	$incr=$max_value*10/100;
	if($horizontal_lines>0)
	{
	$horizontal_gap=$graph_height/$horizontal_lines;
	}

	for($i=1;$i<=$horizontal_lines;$i+=$incr){
		$y=$img_height - $margins - $horizontal_gap * $i ;
		imageline($img,$margins,$y,$img_width-$margins,$y,$line_color);
		$v=intval($horizontal_gap * $i /$ratio);
		imagestring($img,1,5,$y-5,$v,$bar_color);

	}
  	imagestring($img,1,250,290," <---------Day--------->",$bar_color);
 	# ----------- Draw the bars here ------
	for($i=0;$i< $total_bars; $i++){ 
		# ------ Extract key and value pair from the current pointer position
		list($key,$value)=each($values); 
		$x1= $margins + $gap + $i * ($gap+$bar_width) ;
		$x2= $x1 + $bar_width; 
		$y1=$margins +$graph_height- intval($value * $ratio) ;
		$y2=$img_height-$margins;
		imagestringup($img,1,$x1+2,$y1-5,$value,$bar_color);
		imagestring($img,1,$x1+3,$img_height-15,$key,$bar_color);
		imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
		list($key2,$foll)=each($followers); 	
		$y1=$margins +$graph_height- intval($foll * $ratio) ;
		$y2=$img_height-$margins;
		imagestringup($img,1,$x1+10+2,$y1-5,$foll,$bar_color2);
		imagefilledrectangle($img,$x1+11,$y1,$x2+11,$y2,$bar_color2);
	}
	
	while (@ob_end_clean());
	header("Content-type:image/png");
	imagepng($img);
//}
//else{
//	echo "No Results";
//}
	//header("Location:dailyapistats.php")
	?>

