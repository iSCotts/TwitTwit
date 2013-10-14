<?php
ob_start();
session_start();
if ($_SESSION["aff_username"] != "") {
include_once "../includes/header.php";
include_once "../common/dbconfig.php";
include_once "../common/sqlFunctions.php";
$checkcountofaffiliatetable ="SELECT count(*) FROM ta_affiliate_request WHERE UserID = '$_SESSION[aff_username]'";
$checkcountofaffiliatetablestatus = runQuery($checkcountofaffiliatetable);
 if($checkcountofaffiliatetablestatus[0][0] == 0){
		 header("Location:../user/affiliatenonuser.php");
 }
 else
 { ?>
<!-- <script type="text/javascript" src="../js/jquery.js"></script>
<script 	type="text/javascript" src="../js/date.js"></script>
<script 	type="text/javascript" src="../js/jquery.datePicker.js"></script>-->
<script type="text/javascript" src="<?php echo JS_PATH.'jquery.js' ?>"></script>
<script 	type="text/javascript" src="<?php echo JS_PATH.'date.js' ?>"></script>
<script 	type="text/javascript" src="<?php echo JS_PATH.'jquery.datePicker.js' ?>"></script>
<link 	rel="stylesheet" type="text/css" media="screen" 	href="<?php echo CSS_PATH.'datePicker.css' ?>">
<style>
/* located in demo.css and creates a little calendar icon
 * instead of a text link for "Choose date"
 */
a.dp-choose-date {
 float: left;
 width:23px;
 height:20px;
 padding: 0;
 margin:0 0 0 3px;
 display: block;
 text-indent: -2000px;
 overflow: hidden;
 background: url(../images/calender.jpg) no-repeat;
 float:left;
}

a.dp-choose-date.dp-disabled {
 background-position: 0 -20px;
 cursor: default;
}

/* makes the input field shorter once the date picker code
 * has run (to allow space for the calendar icon
 */
input.dp-applied {
 width: 100px;
 float: left;
 padding:2px 0 0 2px;
 height:17px;
 background-color:#fff;
 border:1px solid #3B6F80;
 color:#193842;
 font-size:12px;
 font-family:Verdana, Arial, Helvetica, sans-serif;
 float:left;
}
.affiliate_txtbx{
padding:0 0 0 15px;
width:60px;
float:left;
text-align:left;
}
</style>
 <script type="text/javascript" >
 $(function()
{
	$('.date-pick').datePicker(
					{
						startDate:  (new Date('01/01/1996')).asString(),
						endDate: (new Date()).asString()
										}
				);
	$('#start-date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#end-date').dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	$('#end-date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#start-date').dpSetEndDate(d.addDays(-1).asString());
			}
		}
	);
});
</script>
 <!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="inner_middle_cont">
				<!-- Middle Contents Start -->
				<div class="innermain_head">
					<div class="innermain_head01"><h1> </h1></div>
					<!-- <div class="innermain_pause01"><a href="add_account">Add Mutiple Accounts</a></div>-->
				</div>
				
				<div class="middlecont_01_inner">
				
					<div class="innermid_top"></div>
					<div class="innermid_mid">
						<!-- Inner Page Main Content Start -->
						<div class="subhead_main">
							<div class="subhead_main_head"><h1>Your Affiliate  Details</h1></div>
							</div>
								<?php
						$getaffdetails ="SELECT * FROM ta_affiliate_request WHERE UserID = '$_SESSION[aff_username]'";
						$getaffresult = runQuery($getaffdetails);
						$url= SITE_URL."index.php?q=".$getaffresult[0]['affiliateid'];
						echo "<span style='padding-left:20px;'><strong>Your Affiliate URL </strong> ".$url."</span>";
						echo "<br/><br/><span style='padding-left:20px;'><strong>Check Your Affiliate Sales</strong></span>";
						?>
							<form name="aff_frm" method="POST" action="affnonuser.php" >
							<input type="hidden" name="startdate" id="startdate" value="<?php echo $_REQUEST['start-date'];?>"  />
							<input type="hidden" name="enddate" id="enddate" value="<?php echo $_REQUEST['end-date'];?>"  />
							<div style="padding:15px 0 15px 0;">
								<div class="forms01">
								<div class="inner_title">Start Date</div>
								<div class="inner_boxes">  <input  readonly  name="start-date" id="start-date"  class="date-pick"/></div>
								<div class="clear"></div>
							     </div>
								 <div class="forms01">
								<div class="inner_title">End Date</div>
								<div class="inner_boxes"><input   readonly name="end-date" id="end-date" class="date-pick"/></div>
								<div class="clear"></div>
							</div>
							
							 <div class="forms01">
								<div class="inner_title">&nbsp;</div>
								<div class="inner_boxes"><input type="submit" value="Get Info"  class="inner_txtbtn_01"/></div>
								<div class="clear"></div>
							</div>
								</div>
							</form>
						
						<div class="cont_form_inner">
						
							<!-- Followers Area Start -->
							<div class="editaccounts">
								<div class="followers_top">
									<div class="followers_left"></div>
									<div class="followers_middle">
										<div class="affiliate_middle06"><strong>User Name</strong></div>
										<div class="affiliate_002"><strong>Email</strong></div>
										<div class="affiliate_002"><strong>Package Name</strong></div>
										<div class="affiliate_002"><strong>Amount</strong></div>
										<div class="affiliate_002"><strong>Date</strong></div>
										<div class="clear"></div>
									</div>
									<div class="followers_right"></div>
									<div class="clear"></div>
								</div>
	<?php
	$sqlWhere = '';
	$mc_gross_total =0;
	if(($_REQUEST['startdate'] != '')&&($_REQUEST['enddate'] != ''))
	{
			$start_date = date('Y-m-d',strtotime($_REQUEST['startdate']));
			$end_date = date('Y-m-d',strtotime($_REQUEST['enddate']));
			
			if($start_date == $end_date)
			{
				$sqlWhere.= "  AND sd.`date_record` = '$start_date' ";
			}
			else
			{
				$sqlWhere.= "  AND sd.`date_record` >= '$start_date' ";
				$sqlWhere.= "  AND sd.`date_record` <= '$end_date' ";
			}
		}

			$getaffiliatedetails = "SELECT sd.`sd_id` , sd.`payment_status` , sd.`date_record` , sd.`mc_fee` , sd.`mc_gross` , us.`Email`, us.`UserName` , ".		"us.`next_payment_date` , p.`packageName`"
			."FROM `ta_subscription_details` sd LEFT JOIN `ta_user_subscriptions` us ON sd.`subs_id` = us.`SubsID`"
			."LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID`"
			."LEFT JOIN `ta_affiliate_request` af ON af.`affiliateid` = us.`affiliateid`"
			."WHERE af.`UserID` = '".$_SESSION['aff_username']."' $sqlWhere  GROUP BY us.`SubsID` "
		    . " ORDER BY sd.`date_record` DESC ";
			
			$getaffiliatedetailsresult  = runQuery($getaffiliatedetails);
		    if( count($getaffiliatedetailsresult) >=1 )
		    {
			 for($r=0;$r<count($getaffiliatedetailsresult);$r++)
			 {
			 $mc_gross_total+=$getaffiliatedetailsresult[$r]['mc_gross'];
				?>
							 		<div class="account_01">
									<div class="affiliate_004"><?php echo $getaffiliatedetailsresult[$r]['UserName'];?></div>
									<div class="affiliate_002"><?php echo $getaffiliatedetailsresult[$r]['Email'];?></div>
									<div class="affiliate_002"><?php echo $getaffiliatedetailsresult[$r]['packageName'];?></div>
									<div class="affiliate_002"><?php echo $getaffiliatedetailsresult[$r]['mc_gross'];?></div>
									<div class="affiliate_002"><?php echo  date('d-m-Y',strtotime($getaffiliatedetailsresult[$r]['date_record']));?></div>
									<div class="clear"></div>
								</div>
									<?php
									 }
									 }
									 else{?>
									 	<div style="text-align:center">No Details Found
										<div class="clear"></div>
										</div>	
									 <?php
									 	 }
										 ?>
										 <div style="text-align:right"><?php echo  "Total Sales  $".$mc_gross_total; ?></div>																		 							 	</div>
							<div class="clear"></div>
						</div>
						<!-- Inner Page Main Content End -->
						<div class="clear"></div>
					</div>
					<div class="innermid_btm"></div>
					
					<div class="clear"></div>
				</div>
				<!-- Middle Contents End -->
			</div>
		</div>
	</div>
	<!-- Middle Content Area End -->
	
	
	
		
	  <?php 
include "../includes/footer.php";
}
}

else
{
	header("Location:../index.php");	
}
?>
	 
	 
	 
	