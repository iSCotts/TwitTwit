<?php
/*
 * Created on 25-Jan-2010
 * Author :	liju
 * File:	removeKey.php
 *
 */
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
removeKeyword($_POST['message'],$_POST['campainID']);
?>
