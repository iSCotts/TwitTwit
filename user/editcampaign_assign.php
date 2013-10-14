<?php
session_start();

$_SESSION["SCampaignId"]  = "";
$_SESSION["selectedarray"]  = "";

$_SESSION["SCampaignId"]  = $_REQUEST["CampaignID"];
$_SESSION["selectedarray"]  = "s";
