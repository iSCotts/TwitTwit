<?php
include '../classes/dbClient.php';
include '../common/sqlFunctions.php';
$user=$_REQUEST['name'];
fetchmygroups($user);
