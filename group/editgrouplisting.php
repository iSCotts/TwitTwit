<?php
session_start();
include_once "../config/configoriginal.php";
include_once "../classes/dbClient.php";
include_once "../common/sqlFunctions.php";
include_once "addimgck.php";
if(isset($_SESSION["username"]) && ($_SESSION["username"]!= "")){
    $username=$_SESSION["username"];
	$egid=$_REQUEST['egid'];
	 $sql = "SELECT * FROM `ta_group` where groupOwner='$username' and groupID='$egid'";
    $Getgrouplist = runQuery($sql);
    $egroupname=$Getgrouplist[0]["groupName"];
    $egroupimage=$Getgrouplist[0]["groupImage"];
    $egroupdesc=$Getgrouplist[0]["groupDescription"];	
	if(isset($_REQUEST['update'])){
		$groupname = addslashes($_REQUEST['groupname']);
		$groupdesc = addslashes($_REQUEST['groupdescription']);
		$username=$_SESSION["username"];
		$imagename=$_FILES[groupimage][name];
		//check group name already exists
		$groupnamealreadyexits = "SELECT count(*) FROM `ta_group` WHERE groupName='$groupname' and groupID!='$egid'";
		//echo $groupnamealreadyexits;
	//	$groupnamealreadyexitsresult  =  mysql_query($groupnamealreadyexits);
		 $groupnamealreadyexitsresult = runQuery($groupnamealreadyexits);
		//$groupnamealreadyexitsresult=mysql_fetch_array($groupnamealreadyexitsresult);
		if($groupnamealreadyexitsresult[0][0] == 0){
				
		$updatedate =date("Y-m-d");
		$sqlUpdate ="UPDATE `ta_group` SET `groupName`='$groupname' ,`groupDescription`='$groupdesc' ,`groupModidate`='$updatedate' where groupID=$egid";
		runQuery($sqlUpdate);
    	//$Insertgresult  =  mysql_query($sql);
		if($imagename!= "")
		{
			if(file_exists("origimg/".$Getgrouplist[0]['groupImage']))
			{
		unlink("origimg/".$Getgrouplist[0]['groupImage']);
		unlink("mediumimg/".$Getgrouplist[0]['groupImage']);
		unlink("thumbimg/".$Getgrouplist[0]['groupImage']);
			}
		$getExt = explode ('.', $imagename);
        $file_ext = $getExt[count($getExt)-1];
        $fileName=$egid.".".$file_ext;
        $thumbloc="thumbimg/";
        $mediumloc="mediumimg/";
        $n_width=60;
        $n_height=60;
        $m_width=100;
        $m_height=100;
		$add="origimg/".$fileName; // the path with the file name where the file will be stored, upload is the directory name. 
			if(move_uploaded_file ($_FILES[groupimage][tmp_name],$add)){
			$result=uploadimage($fileName,$_FILES[groupimage][tmp_name],$_FILES[groupimage][type],$add,$thumbloc,$n_width,$n_height);
			$result2=uploadimage($fileName,$_FILES[groupimage][tmp_name],$_FILES[groupimage][type],$add,$mediumloc,$m_width,$m_height);
			$sqlUpdate2="update `ta_group` set groupImage='$fileName' where groupID=$egid";
			runQuery($sqlUpdate2);
			}
			else
		  {
			$ErrorMessage = "Error occured while uploading image";
		    }
		 }
		 	if($egid!= ""){
						header("Location:grouphome?id=$egid");
						//header("Location:grouplisting.php?act=1");
							}
						else{
							$ErrorMessage = "Some problem while editing ";
						}			
		}
				else
		  {
			$ErrorMessage = "Group name already exists";
		    }
	}
}
else{
	header("Location:../index");
}
?>
<?php  include "../includes/header.php"; ?>
	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="middle_group">
				<!-- Middle Contents Start -->
				
				<!-- Middle Left Start -->
				<div class="middle_groupleft">
					<div><h1>Edit your Group</h1></div>
					
					<div>
						<br /><h2>Lorem ipsum dolor sit amet, consectetur adipisicing elit</h2>
						
						<p>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br /><br /></p>
						
						<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
						
						<p> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
						
					</div>
					
					<div>
						<h2>Edit Group</h2>
					</div>
					<div style="color:#ff0000;padding:0px 55px;" ><?php print $ErrorMessage ?></div>
					<form name="addgroup" id="addgroup" action="" method="post" enctype="multipart/form-data" onsubmit="return validate(this)">
		
					<div>
						<div class="forms04">
							<div class="group_title">Group name</div>
							<div class="float"><input type="text" class="search_txt" name="groupname" value="<?php echo  $egroupname; ?>" /></div>
							<div class="clear"></div>
							<div id="namelbl" style="color:#ff0000;padding:0px 145px;" ></div>
							</div>
							<div class="forms04">
							<div class="group_title">Upload image</div>
								<input type="text" id="fileName" name="fileName" class="file_input_textbox" readonly="readonly" />
							<div class="float">
								<div class="file_input_div">
								  <input type="button" style="float:left" value="Browse" class="file_input_button" />
								  <input type="file"  name="groupimage" style="float:left" class="file_input_hidden" onchange="javascript: document.getElementById('fileName').value = this.value" />
								<?php if($egroupimage!=""){ ?>
								&nbsp;&nbsp;<img src="thumbimg/<?php echo $egroupimage?>" />
								<?php }?>
								</div>
							</div>
							<div class="clear"></div>
							<div id="filelbl" style="color:#ff0000;padding:0px 145px;" ></div>
						    </div>
						<div class="forms01">
							<div class="group_title">&nbsp;</div>
							<div class="img_description">Picture maximum dimensions: 200x200</div>
							<div class="clear"></div>
						</div>
						<div class="forms02">
							<div class="group_title">Description</div>
							<div class="float"><textarea rows="" cols="" name="groupdescription" class="group_txtarea"><?php echo $egroupdesc; ?></textarea></div>
							<div class="clear"></div>
							<div id="desclbl" style="color:#ff0000;padding:0px 145px;" ></div>
						</div>
						<div class="forms04">
							<div class="group_title">&nbsp;</div>
							<div class="float"><input type="submit" name="update" value="Update Group" class="search_btn" /></div>
							<div class="clear"></div>
						</div>
					</div>
					</form>
				</div>
				<!-- Middle Left Start -->
              <?php include "leftlink.php"; ?>	
				<div class="clear"></div>
				<!-- Middle Contents End -->
			</div>
		</div>
	</div>
	<!-- Middle Content Area End -->
	
	<?php include "../includes/footer.php"; ?>	