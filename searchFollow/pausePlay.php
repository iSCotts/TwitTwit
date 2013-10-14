<?php
/*
 * Created on 27-Jan-2010
 * Author :	liju
 * File:	pausePlay.php
 *
 */
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
$result = pausePlay($_POST['message'], $_POST['campainID']);
if ($result == 'A') {
	$status = 'pause';
	$img="pause_small.png";

}
elseif ($result == 'I') {
	$status = 'start';
	$img="play_small.png";
}
$statusPrint=ucfirst($status);
echo "<a onclick=\"pausePlay('{$_POST['campainID']}','{$_POST['message']}','{$status}')\" >
		<img src=\"../images/{$img}\" alt=\"\" title=\"{$statusPrint} auto following conversations about {$_POST['message']}\"></a>";
?>
