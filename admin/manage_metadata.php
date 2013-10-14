<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";
//patht to the fckeditor class
include("fckeditor/fckeditor.php");

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
    $getResult = $_REQUEST["act"];
	if($getResult == 3)
	$ErrorMessage = "Data Updated Successfully";
if(isset($_REQUEST["Add"]) && $_REQUEST["Add"] == "Save")
	{
		$filename = "../common/meta_main.php";
		$fh = fopen($filename, 'w') or die("can't open file");
		$stringData =$_REQUEST["file_contents"];
		fwrite($fh, stripslashes($stringData));
		fclose($fh);
		header("Location:manage_metadata.php?act=3");
	}
?>
<td height="380" align="center" valign="top">
<form name="metadatafrm" id="metadatafrm"  action="manage_metadata.php" method="post" >
<table cellpadding="2" cellspacing="2" border="0">
<tr>
<td colspan="2" align="center">manage Metadata</td>
</tr>
<tr>
<td colspan="2" align="center" style="color:#003300"><?php print $ErrorMessage ?></td>
</tr>
<tr>
<td><textarea name="file_contents" rows="10" cols="20">
<?php
$filename = "../common/meta_main.php";
$file = fopen($filename, "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
while(!feof($file))
  {
  echo fgets($file);
  }
fclose($file);
?>
</textarea></td>
</tr>
<tr>
<td colspan="2"   align="center"><input type="submit" name="Add" id="Add" value="Save"></td>
</tr>
</table>
</form>
</td>
</tr>
<?php
include "includes/footer.php";
 }
 else
 {
 header("Location:index.php?act=3");
 }

 ?>