<?php
/*
function dbconnect(){
   $link = mysql_pconnect('localhost', 'twail', 'mon917am');
   $db_selected = mysql_select_db('logics_twail', $link);
}

*/
include_once "config/config.php";
function generateurl($numAlpha=6)
{
  // dbconnect();
   $listAlpha = 'abcdefghijklmnopqrstuvwxyz0123456789';
   return str_shuffle(
   substr(str_shuffle($listAlpha),0,$numAlpha)
  );
}
function geturl($in)
{
  // dbconnect();
    $link = mysql_connect(HOST, USERNAME, PASSWORD);
   $db_selected = mysql_select_db(DATABASE, $link);
   
 
   do{
     $out = generateurl();
  $query = "SELECT short  FROM `ta_short_urls` WHERE `short` = '$out'";
 $result = mysql_query($query);
   } while (mysql_num_rows($result) >0);
 $phpdate = date('Y-m-d H:i:s');
 $insert_query = "INSERT INTO `ta_short_urls` (`short`, `url`, `stamped`) VALUES ( '$out', '$in','$phpdate')";
 $result = mysql_query($insert_query);
 mysql_close($link);
 //return "http://YOUR.COM/".$out;
  //return SITE_URL.$out;
 return "http://twitjix.com/".$out;
}
?>