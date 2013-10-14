<?php ob_start();
 include_once "../config/config.php";
$link = mysql_pconnect(HOST, USERNAME, PASSWORD);
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// make foo the current db
$db_selected = mysql_select_db(DATABASE, $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
	# ------- The graph values in the form of associative array
$values=array("00" => 0,	"01" => 0,	"02" => 0,	"03" => 0,	"04" => 0,	"05" => 0,	"06" => 0,	"07" => 0,	"08" => 0,	"09" => 0,	"10" => 0,	"11" => 0,
		"12" => 0,	"13" => 0,	"14" => 0,	"15" => 0,	"16" => 0,	"17" => 0,	"18" => 0,	"19" => 0,	"20" => 0,	"21" => 0,"22" => 0,"23" => 0, "24" => 0	
	);

//print_r($values);
//$dateselect="2010-04-09";	
//$apitype="friendships/create";
$dateselect=$_REQUEST['datetext'];
$apitype=$_REQUEST['apimethod'];
if($apitype=="All")
{
$sql="SELECT DATE_FORMAT( `DT` , '%H:00 %T' ) AS HOUR , count( * ) AS mycount
FROM ta_api_statistics WHERE `DT` LIKE '%{$dateselect}%' GROUP BY DATE( `DT` ) , HOUR( `DT` )";	
}
else{
$sql="SELECT DATE_FORMAT( `DT` , '%H:00 %T' ) AS HOUR , count( * ) AS mycount
FROM ta_api_statistics WHERE `DT` LIKE '%{$dateselect}%' and apitype = '{$apitype}'
GROUP BY DATE( `DT` ) , HOUR( `DT` )";
}
//$sql ="SELECT apitype,DT FROM `ta_api_statistics` WHERE apitype = '{$apitype}' and DATE_FORMAT(DT, '%Y-%m-%d') = '{$dateselect}'";
$statCount = @mysql_query($sql, $link);

//$statCount = runQuery($sql);
//$statCount = mysql_fetch_array($statCount);
//echo $statCount[0]['HOUR'];
//exit;
//$values=array();
$num_rows = mysql_num_rows($statCount);
while ($row = mysql_fetch_array($statCount)) {
	$hours=$row['HOUR'];
	$curhour=explode(":",$hours);
    $count=$row['mycount'];
	$ehour=$curhour[0];
	$values[$ehour]=$count;
   }
	//print_r($values);
	// exit;
 
	$img_width=650;
	$img_height=300; 
	$margins=30;

 
	# ---- Find the size of graph by substracting the size of borders
	$graph_width=$img_width - $margins * 2;
	$graph_height=$img_height - $margins * 2; 
	$img=imagecreate($img_width,$img_height);

 
	$bar_width=20;
	$total_bars=count($values);
	$gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1);

 
	# -------  Define Colors ----------------
	$bar_color=imagecolorallocate($img,0,64,128);
	$background_color=imagecolorallocate($img,240,240,255);
	$border_color=imagecolorallocate($img,200,200,200);
	$line_color=imagecolorallocate($img,220,220,220);
 
	# ------ Create the border around the graph ------

	imagefilledrectangle($img,1,1,$img_width-2,$img_height-2,$border_color);
	imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);

 
	# ------- Max value is required to adjust the scale	-------
	$max_value=max($values);
	$ratio= $graph_height/$max_value;

 
	# -------- Create scale and draw horizontal lines  --------
	$horizontal_lines=$max_value;
	if($max_value>10)
	{
	$incr=$max_value*10/100;
	}
	else{
	$incr=1;	
	}
	$horizontal_gap=$graph_height/$horizontal_lines;

	for($i=1;$i<=$horizontal_lines;$i+=$incr){
		$y=$img_height - $margins - $horizontal_gap * $i ;
		imageline($img,$margins,$y,$img_width-$margins,$y,$line_color);
		$v=intval($horizontal_gap * $i /$ratio);
		imagestring($img,1,5,$y-5,$v,$bar_color);

	}
  	imagestring($img,1,250,290,"<--------- Hour --------->",$bar_color);
 	# ----------- Draw the bars here ------
	for($i=0;$i< $total_bars; $i++){ 
		# ------ Extract key and value pair from the current pointer position
		list($key,$value)=each($values); 
		$x1= $margins + $gap + $i * ($gap+$bar_width) ;
		$x2= $x1 + $bar_width; 
		$y1=$margins +$graph_height- intval($value * $ratio) ;
		$y2=$img_height-$margins;
		
		imagestring($img,1,$x1+3,$y1-10,$value,$bar_color);
		imagestring($img,1,$x1+3,$img_height-15,$key,$bar_color);		
		imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
	}

	while (@ob_end_clean());
	header("Content-type:image/png");
	imagepng($img);

	//header("Location:dailyapistats.php")
	?>

