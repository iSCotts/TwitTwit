<?php
include_once("config.php");
$link = mysql_pconnect(HOST,USERNAME, PASSWORD);
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// make foo the current db
$db_selected = mysql_select_db(DATABASE, $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
