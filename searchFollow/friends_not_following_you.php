<?php ob_start();
session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Unfollow Tool</title>
<link href="../css/home.css" rel="stylesheet" type="text/css" />
<link href="../css/main.css" rel="stylesheet" type="text/css" />
  <style>
  body
  {
  	background:none;
  }
   a {
    color: #333;
    text-decoration: none;
   }
   a:hover {
    text-decoration: underline;
   }
   a.selected {
    font-weight: bold;
    text-decoration: underline;
   }
   .numbers {
    line-height: 20px;
    word-spacing: 4px;
   }
   .group_userfollowing {
    margin:0 0 0 20px;
	padding:10px;
	width:840px;
	height: auto;
	background:url(../images/gshad-in.png) repeat;
	}
	.group_userfollowing01 {
	margin:5px 0 0 0;
	padding:0 0 0 0;
	width:835px;
	height:auto;
	}
	.group_userfollowing01 ul {
	padding:0 0 0 5px;
	margin:0 0 0 0;
	list-style:none;
	}
	.group_userfollowing01 li {
	padding:0 2px 0 3px;
	margin:0 0 0 0;
	float:left;
	}

h3{
color:#000000;
font-weight:bold;
margin-left:10px;
font-family:Arial, Helvetica, sans-serif;
}

  </style>
 </head>

<body onLoad="init()"> 
<div id="loading" style="position:absolute; width:100%; text-align:center; top:80px;"><img src="../images/loading-first.gif" border=0></div> 
<script> 
var ld=(document.all);
 
var ns4=document.layers;
var ns6=document.getElementById&&!document.all;
var ie4=document.all;
 
if (ns4)
	ld=document.loading;
else if (ns6)
	ld=document.getElementById("loading").style;
else if (ie4)
	ld=document.all.loading.style;
 
function init()
{
if(ns4){ld.visibility="hidden";}
else if (ns6||ie4) ld.display="none";
}
</script> 
<?php
//unset($_SESSION['notFList']);
include_once('cronClasses.php');
$userKeys = dkGetUserKeys($_SESSION['username']);
if(count($userKeys)==0) header('Location : ../index.php');
include_once('../classes/class.pagination.php');
function truncate($text, $limit = 25, $ending = '...')
{
 if (strlen($text) > $limit) 
 {
   $text = substr($text, 0, $limit);
   $text = $text . $ending;
 }
 return $text;
}
?>
<!-- All Members List box Start -->
<h3>Manual unfollow tool</h3>

					<div class="forms02">
						<div class="group_userfollowing">

							<div class="forms01"><h5>Friends not following you</h5></div>
							<div class="group_userfollowing01">
								<ul>
								
<?php
$pageNumbers='';
if(empty($userKeys[0]['key'] )|| empty($userKeys[0]['secretkey']))
{
	echo 'Login through "login with twitter" login method and get friends not following you.';
}
else
{
$followFriend = new SearchFollowAPI($userKeys[0]['key'],$userKeys[0]['secretkey']);
if(isset($_SESSION['notFList']))
{
	$notFollowingList = $_SESSION['notFList'];
}
else
{
	$notFollowingList = array();
}
if(count($notFollowingList) ==0)
{
	$x = $followFriend->dkNotFollowingList();
	if(!$x)
	{
		echo '<br/> User API rate limit over. Please try after some time.';
	}
	else
	{
		$_SESSION['notFList'] = $notFollowingList = $x;
	}
}
$pagination = new pagination;
// If we have an array with items
if (count($notFollowingList) !=0) 
{
	if($_GET['act'] == 'uf' && !empty($_GET['sn']))
	{
		$followFriend->dkUnfollowUser($_GET['sn']);
		unset($notFollowingList[$_GET['sn']]);
		unset($_SESSION['notFList']);
		$_SESSION['notFList'] = $notFollowingList;
		unset($_GET['act']);
		unset($_GET['sn']);
		unset($_GET['ai']);
	}
	// Parse through the pagination class
	$notFollowingListPages = $pagination->generate($notFollowingList, 30);
	// If we have items 
	if (count($notFollowingListPages) != 0) 
	{
		// Create the page numbers
		$pageNumbers = '<div class="numbers" >'.$pagination->links().'</div>';
		// Loop through all the items in the array
		foreach( $notFollowingListPages as $key => $value)
		{
		  $temp = 'friends_not_following_you.php?act=uf&sn='.$key.'&page='.$_GET['page'];
?>
			<!-- Member area box 01 Start -->
			<li>
				<div class="allmembers">
					<div class="group_userthump01">
						<a href="http://twitter.com/<?php echo $key;?>" target="_blank">
							<img src="<?php echo $value;?>" alt="" border="0" height="50" width="50" />
						</a>
					</div>
					<div class="group_userthumpname">
						<a href="http://twitter.com/<?php echo $key;?>" target="_blank">
							<?php echo truncate($key,12);?>
						</a>
					</div>
	
					<div class="middle_userthumplink">
						<a href="<?php echo $temp;?>">
							<img src="../images/remove-user.png" alt="Unfollow This User" title="Unfollow This User" />
						</a>
					</div>
					<div class="clear"></div>
				</div>
			</li>
			<!-- Member area box 01 Start -->
<?php		
		}
	}
}
}
?>
									<div class="clear"></div>
								</ul>
								<div class="clear"></div>
							</div>
							<div class="paging">
								<?php echo $pageNumbers;?>
							</div>
						</div>
					</div>
<!-- All Members List box End -->
</body>
</html>