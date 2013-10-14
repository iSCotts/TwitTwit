<?php
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
$id = $_REQUEST["id"];

$sql = "SELECT * FROM ta_email_template WHERE t_id ='$id'";
$gettempdetails = runQuery($sql);
?>

<table cellpadding="1" cellspacing="1" border="0">
<tr>
<td><?php echo $gettempdetails[0]["t_name"] ?></td>
</tr>
<tr>
<td>
<?php
if(file_exists("../mailtempl/".$gettempdetails[0]["t_file"]))
{
$file = fopen("../mailtempl/".$gettempdetails[0]["t_file"], "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
while(!feof($file))
  {
  echo fgets($file). "<br />";
  }
fclose($file);
}
?>
</td>
</tr>

</table>

