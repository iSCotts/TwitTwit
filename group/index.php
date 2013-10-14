<?php
session_start();
include_once "../config/configoriginal.php";
include_once "../classes/dbClient.php";
include_once "../common/sqlFunctions.php";
include_once "addimgck.php";
//include_once "imageupload.php";
if(isset($_SESSION["username"]) && ($_SESSION["username"]!= "")){
	if(isset($_REQUEST['create'])){
		$groupname = trim($_REQUEST['groupnametxt']);
		if($groupname=="")
		{
		$ErrorMessage = "Please enter a valid group name";
			}
		else{	
		$groupdesc = addslashes($_REQUEST['groupdescription']);
		$username=$_SESSION["username"];
		$imagename=$_FILES[groupimage][name];
		//check group name already exists
		$groupnamealreadyexits = "SELECT count(*) FROM `ta_group` WHERE groupName='$groupname'";
		$groupnamealreadyexitsresult  =  mysql_query($groupnamealreadyexits);
		$groupnamealreadyexitsresult=mysql_fetch_array($groupnamealreadyexitsresult);
		if($groupnamealreadyexitsresult[0][0] == 0){
				
		$createdate =date("Y-m-d");
			
		$sql ="INSERT INTO `ta_group` (`groupName` ,`groupDescription` ,`groupOwner` ,`groupCreatedate`)
VALUES ( '$groupname', '$groupdesc', '$username', '$createdate');";
		//	$sql = "INSERT INTO 'ta_group` (`groupName`,`groupImage`,`groupDescription`,`groupOwner`,`groupCreatedate`)VALUES ($groupname,'',$groupdesc,`$username`,`$createdate`)";
		$Insertgresult  =  mysql_query($sql);
		$insertid=mysql_insert_id();
		//insert into the member table also......
		$membersql="INSERT INTO `ta_group_members` (`groupID` ,`memberName` ,`memberjDate`)
VALUES ( '$insertid', '$username', '$createdate');";
		$Insertmembresult  =  mysql_query($membersql);
		
		if($imagename!= "")
		{
		$getExt = explode ('.', $imagename);
        $file_ext = $getExt[count($getExt)-1];
        $fileName=$insertid.".".$file_ext;
        $thumbloc="thumbimg/";
        $mediumloc="mediumimg/";
        $n_width=60;
        $n_height=60;
        $m_width=100;
        $m_height=100;
       // echo $_FILES['groupimage']['tmp_name'];
    	    $add="origimg/".$fileName; // the path with the file name where the file will be stored, upload is the directory name. 
			if(move_uploaded_file ($_FILES[groupimage][tmp_name],$add)){
			$result=uploadimage($fileName,$_FILES[groupimage][tmp_name],$_FILES[groupimage][type],$add,$thumbloc,$n_width,$n_height);
			$result2=uploadimage($fileName,$_FILES[groupimage][tmp_name],$_FILES[groupimage][type],$add,$mediumloc,$m_width,$m_height);
			$sqlUpdate="update `ta_group` set groupImage='$fileName' where groupID=$insertid";
			mysql_query($sqlUpdate);
			}
			else
		  {
			$ErrorMessage = "Error occured while uploading image";
		    }
		 }
		 	if($insertid!= ""){
						header("Location:grouphome?id=$insertid");
						//header("Location:grouplisting.php?act=1");
						exit;
						}
						else{
							$ErrorMessage = "Some problem while Inserting ";
						}			
		}
				else
		  {
			$ErrorMessage = "Group name already exists";
		    }
	}
}
}
else{
	header("Location:../index");
}
if(isset($_REQUEST["act"]) && ($_REQUEST["act"]==5)){
$ErrorMessage = "Group deleted successfully";
}
?>

<?php  include "../includes/header.php"; ?>		
	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="middle_group">
				<!-- Middle Contents Start -->
				<form name="addgroup" id="addgroup" action="" method="post" enctype="multipart/form-data" onsubmit="return validate(this)">
				<!-- Middle Left Start -->
				<div class="middle_groupleft">
					<div><h1>Create a Group</h1></div>
					
					<div>
						<br /><h2>Cant find the group you are looking for?</h2>
						
						<p>Everyone in a group follows everyone else in a group - if you leave a group everyone will unfollow you, you will still follow them.<br /><br /></p>
						
						<p><strong>Public Groups:</strong> anyone can join a public group, once it is created that is it - no one controls the group. It will be publically visible on the internet.<br /><br /></p>
						
						<p><strong>Private Groups:</strong> to come soon (likely to be a paid service), expect to see a couple of options, such as invite only and an option to earn you money.<br /><br /></p>
						
					</div>
					
					<div>
						<h2>Create Group</h2>
					</div>
					<div style="color:#c19700;padding:0px 55px;" ><?php print $ErrorMessage ?></div>
					
		
					<div>
						<div class="forms04">
							<div class="group_title">Group name</div>
							<div class="float"><input type="text" class="search_txt" name="groupnametxt" value="" /></div>
							<div class="clear"></div>
							<div id="namelbl" style="color:#c19700;padding:0px 145px;" ></div>
							</div>
							<div class="forms04">
							<div class="group_title">Upload image</div>
								 <input type="text" id="fileName" name="fileName" class="file_input_textbox" readonly="readonly" />
							<div class="float">
								<div class="file_input_div">
								  <input type="button" style="float:left" value="Browse" class="file_input_button" />
								  <input type="file"  name="groupimage" style="float:left" class="file_input_hidden" onchange="javascript: document.getElementById('fileName').value = this.value" />
								</div>
							</div>
							<div class="clear"></div>
							<div id="filelbl" style="color:#c19700;padding:0px 145px;" ></div>
						    </div>
						<div class="forms01">
							<div class="group_title">&nbsp;</div>
							<div class="img_description">Picture maximum dimensions: 200x200</div>
							<div class="clear"></div>
						</div>
						<div class="forms02">
							<div class="group_title">Description</div>
							<div class="float"><textarea rows="" cols="" name="groupdescription" class="group_txtarea"></textarea></div>
							<div class="clear"></div>
							<div id="desclbl" style="color:#c19700;padding:0px 145px;" ></div>
						</div>
						<div class="forms04">
							<div class="group_title">&nbsp;</div>
							<div class="float"><input type="submit" name="create" value="Create Group" class="search_btn" /></div>
							<div class="clear"></div>
						</div>
					</div>
				
				</div>
				</form>
				<!-- Middle Left Start -->
              <?php include "leftlink.php"; ?>	
				<div class="clear"></div>
				<!-- Middle Contents End -->
			</div>
		</div>
	</div>
	<!-- Middle Content Area End -->
	
	<?php include "../includes/footer.php"; ?>	