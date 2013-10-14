<?php
session_start();

/*
 * Created on 28-Dec-2009
 * Author :	root
 * File:	feed.php
 * 
 */


include '../classes/dbClient.php';
include '../common/sqlFunctions.php';

$rr = addFeed($_REQUEST);
if($rr =="ok" ){
header("Location:managefeed.php?act=2");
}

if($rr =='error' ){
header("Location:index.php?act=3");
}

 

?>
