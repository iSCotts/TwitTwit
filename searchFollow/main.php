<?php
/*
 * Created on 28-Jan-2010
 * Author :	liju
 * File:	main.php
 *
 */
session_start();
//ini_set("max_execution_time","20000000000000000000000");
//ini_set("max_input_time","2500000");
//ini_set("memory_limit","25000000M");
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
$getIDs = getUserPASSId($_REQUEST['username']);
$name = $getIDs[0]['Username'];
$uname=$_REQUEST['uname'];
if($uname=="")
{
$uname=$_SESSION["username"];
}
/**
 * setting Password
 */
$pass = $getIDs[0]['secretkey'];
/**
 * gets the users keyword from database
 */
$users = getUserId($getIDs[0]['Username']);
$usersKeywords = getKeywordSearchForUser($_REQUEST['CampaignID'], $name);
/**
 * getting number of used keywords and total number of keywords
 *
 *
 * $keywordLimit = getkeywordLimit($getIDs[0]['Username']);
 */


$html= "<table id='tlTable' style=background:none;>";
$arrayCount = count($usersKeywords);
/**
 * dispaly the rows for each keyword
 */
for ($i = 0; $i < $arrayCount; $i++) {
	//$res=setKeywordfollowersForUserkeyword($_REQUEST['CampaignID'], $usersKeywords[$i]['KeyId'], $usersKeywords[$i]['UserId']);
	$html .= quickKeywordRun($usersKeywords[$i], $_REQUEST['CampaignID'], $uname,$name);
}
$html .= "</table>";
print $html;
?>

<div class="account_select">
<?php 
	$dkPackage 			= dkGetPackagedetails($uname);
	$dkNoCampaignKeys	= dkGetNoCampaignKeywords($_REQUEST['CampaignID']); 
	
?>
 <div class="account_title" >
<!-- <select id ='type' name="type" class="inner_option_medium">
	<option value="follow">Follow</option>
	<option value="suggest">Suggest</option>
</select>
-->Find Me
	</div>
	<div class="account_title">
	<select id ="count" name="count" class="inner_option_medium">
	<?php
	
	switch ($dkPackage['followLimit'])
	{
	case "Unlimited":
			for ($j = 10; $j<=50; $j+=10) {
			?>
			<option value="<?php echo $j ?>">up to <?php echo $j?></option>
			<?php }
			?>
			<option value="100">up to 100</option>
			<option value="200" selected="true">up to 200</option>
			<option value="500">up to 500</option>
			<option value="1000">up to 1000</option>
			<option value="1">unlimited</option>
			<?php 
	break;
	case "unlimited":
			for ($j = 10; $j<=50; $j+=10) {
			?>
			<option value="<?php echo $j ?>">up to <?php echo $j?></option>
			<?php }
			?>
			<option value="100">up to 100</option>
			<option value="200" selected="true">up to 200</option>
			<option value="500">up to 500</option>
			<option value="1000">up to 1000</option>
			<option value="1">unlimited</option>
			<?php 
	break;
	case 100:
			 for ($j = 10; $j<=50; $j+=10) {
				?>
				<option value="<?php echo $j ?>">up to <?php echo $j?></option>
			<?php }
			?>
			<option value="100">up to 100</option>	
			<?php 
	  break;
	case 200:
		    for ($j = 10; $j<=50; $j+=10) {
				?>
				<option value="<?php echo $j ?>">up to <?php echo $j?></option>
			<?php }
			?>
			<option value="100">up to 100</option>
			<option value="200" selected="true">up to 200</option>
			<?php 
	  break;
	  case 500:
		    for ($j = 10; $j<=50; $j+=10) {
				?>
				<option value="<?php echo $j ?>">up to <?php echo $j?></option>
			<?php }
			?>
			<option value="100">up to 100</option>
			<option value="200" selected="true">up to 200</option>
			<option value="500">up to 500</option>
			<?php 
	  break;
	  case 1000:
		    for ($j = 10; $j<=50; $j+=10) {
				?>
				<option value="<?php echo $j ?>">up to <?php echo $j?></option>
			<?php }
			?>
			<option value="100">up to 100</option>
			<option value="200" selected="true">up to 200</option>
			<option value="500">up to 500</option>
			<option value="1000">up to 1000</option>
			<?php 
	  break;
	default:
	 		for ($j = 10; $j<=$dkPackage['followLimit']; $j++) {
				?>
				<option value="<?php echo $j ?>">up to <?php echo $j?></option>
			<?php }
	 }
?>
	 </select>

								</div>
								<div class="account_title">

	<select id='lang' name="lang" class="inner_option_medium01">
	<option value="en" selected="true">English speaking</option>
	<option value="fr">French speaking</option>
	<option value="es">Spanish speaking</option>
	<option value="de">German speaking</option>
	<option value="pt">Portuguese speaking</option>
	<option value="ja">Japanese speaking</option>
	<option value="any">Global</option>
</select>


								</div>
								<!--<div class="title_keyword">Keywords </div>-->users, talking about 
	<input type="text" class="inner_txtbx_03" name="addkeyword" id="addkeyword"   />
	<input type="hidden" class="hidden" id='name' name="name" value="" />
	<!-- <input type="hidden" class="hidden" id='username' name="username" value="<?php // print $_REQUEST['username']?>" />-->
	<input type="hidden" class="hidden" id='CampaignID' name="CampaignID" value="<?php print $_REQUEST['CampaignID']?>" />
	<input type="hidden" class="hidden" id='id' name="id" value="<?php print $users[0]['UserID']?>" />
	<input type="hidden" class="hidden" id="uname" name="uname" value="<?php print $uname?>" />
	<input type="button" class="inner_txtbtn_01" onclick="submitDetails();" name="submit" value="Add" />
								<div class="clear"></div>
						
							</div>
							
							
						</div>
<?php
if($dkNoCampaignKeys >= $dkPackage['keywordLimit'])
{
?>
<script type="text/javascript" language="javascript">
	var waringMSG = 'You have created <?php echo $dkNoCampaignKeys;?> campaign keywords and your campaign keyword limit is over. Please <a href="upgrade">upgrade your account.</a>';
	if(document.getElementById('error_keyword'))
	{
		document.getElementById('error_keyword').innerHTML = waringMSG;
	}
	else
	{
		$("#tlTable").append('<span class="error" id="error_keyword" >'+waringMSG+'</span>');
	}
</script>
<?php
}
?>

