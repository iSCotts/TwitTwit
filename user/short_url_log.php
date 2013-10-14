<?php
include "../classes/dbClient.php";
include "../common/sqlFunctions.php";
$id	= $_REQUEST['id'];
$query 				= "SELECT * FROM `ta_short_urls_log` WHERE id  ='".$_REQUEST['id']."'";
$tempRes 			= runQuery($query);
?>
<table width="100%" border="1">
  <tr style=" text-align:center">
    <td >Date & Time</td>
    <td >Ip Address</td>
    <td >Ip Country</td>
    <td >Ip Region</td>
    <td >Ip City</td>
  </tr>

<?php
for($i=0;$i<count($tempRes);$i++)
{
?>
  <tr style=" text-align:center">
    <td><?php echo $tempRes[$i]['log_dt'];?></td>
    <td><?php echo $tempRes[$i]['ip_address'];?></td>
    <td><?php echo $tempRes[$i]['ip_country'];?></td>
    <td><?php echo $tempRes[$i]['ip_region'];?></td>
    <td><?php echo $tempRes[$i]['ip_city'];?></td>
  </tr>
<?php
}
?>
</table>


