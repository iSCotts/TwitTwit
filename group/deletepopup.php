<?php 
if(isset($_REQUEST['groupname']))
{
$deleteid=$_REQUEST['deleteid'];
$groupname=$_REQUEST['groupname'];
	?>
<!-- <link href="../css/popup.css" rel="stylesheet" type="text/css" /> -->
 <div style="text-align:center; color:#fff;">
								<div class="con-popup">
									<br />You are about to delete the group &quot; <strong><?php echo $groupname; ?></strong> &quot;. <br /><h5>Do you want to continue?</h5><br />
									<a href="mygroups?deleteid=<?php echo $deleteid; ?>"><img src="../images/yes.png"></img></a> &nbsp;<a href="mygroups"> <img src="../images/no.png"></img></a>
								</div>
							</div>
<?php
}
?>							

<?php 
if(isset($_REQUEST['searchtext']))
{
$deleteid=$_REQUEST['deleteid'];
$searchtext=$_REQUEST['searchtext'];
	?>
<!-- <link href="../css/popup.css" rel="stylesheet" type="text/css" /> -->
 <div style="text-align:center; color:#fff;">
								<div class="con-popup">
									<br />You are about to delete the group &quot; <strong><?php echo $groupname; ?></strong> &quot;. <br /><h5>Do you want to continue?</h5><br />
									<a href="searchlisting?deleteid=<?php echo $deleteid; ?>&searchtext=<?php echo $searchtext;?>"><img src="<?php echo IMG_PATH."yes.png";?>"></img></a> &nbsp;<a href="mygroups"> <img src="<?php echo IMG_PATH."no.png";?>"></img></a>
								</div>
							</div>
<?php
}
?>		



 