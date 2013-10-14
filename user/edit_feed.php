<?php
 include "../includes/header.php";
 
  $refuser123 = $_SESSION["username"];
 

if($_SESSION["username"] != "" && $_SESSION["password"] !="" ){

  if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==3)){
 $Message = "Your Details Already there";}
 
 

  
  if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==3)){
 $Message = "Your Details Already there";}
?>

 
 <form action="edit_feedaction" method="post" name="rssform" onSubmit="return RssformValidation();">

<!--<h4 style="font-weight: 100; margin-bottom: 10px;">Twitter Name</h4>
<input id="feed_username" name="username" size="20" value="" type="text"/>-->
<?php
$getRssDetails = "SELECT * FROM ta_feeds WHERE UserID='$_REQUEST[uid]' && id 	='$_REQUEST[id]'";
$getRssDetailsResults  = runQuery($getRssDetails);
?>
 <h4 style="font-weight: 100; margin-bottom: 10px;"><?php print $Message ?></h4>
<h4 style="font-weight: 100; margin-bottom: 10px;">Feed Name</h4>
<input id="feed_feedname" name="feedname" size="20" value="<?php print $getRssDetailsResults[0]["feedname"] ?>" type="text"/>
<h4 style="font-weight: 100; margin-bottom: 10px;">RSS Feed URL</h4>
<input id="feed_feedurl" name="feedurl" size="70" value="<?php print $getRssDetailsResults[0]["feedurl"] ?>" type="text" onblur="checkURLtest();"/>
        
       
       
       
       <div id="feed_urlstatus"></div>
       
       
<!--  <div id='feed_urlstatus'></div>
<input name="isactive" value="0" type="hidden"><input checked="checked" id="feed_isactive" name="isactive" value="1" type="checkbox"/> 
<label for="feed_isactive" style="float: none;">Active</label>


<br/>-->

<div id='posturl'></div>
 
<input id="posturl" name="posturl" value="1" type="checkbox" <?php if($getRssDetailsResults[0]["posturl"] == 1){  print "Checked"; }?> /> 
<label for="posturl" style="float: none;">posturl</label>


<input id="shorturl" name="shorturl" value="1" type="checkbox" <?php if($getRssDetailsResults[0]["shorturl"] == 1){  print "Checked"; }?> /> 
<label for="shorturl" style="float: none;">shorturl</label>


<br/>

<input type="hidden" name="ID" value="<?php print $getRssDetailsResults[0]["id"]?>">


ADVANCE SETTING

<input type="hidden" name="susername" value="<?php print $_SESSION["username"]?>">


<h4> Sort  Id </h4>
   <select id="sortid" name="sortid">
    <option value="0"  >Select Sort id</option>
<option value="1" <?php if($getRssDetailsResults[0]["sortid"] == 1){  print "Selected"; } ?> >PubDate</option>
<option value="2" <?php if($getRssDetailsResults[0]["sortid"] == 2) { print "Selected"; } ?>>guid</option>
 </select>


 <h4> Update Frequency </h4>
  Check for new posts <select id="feed_freq_id" name="freq_id">
  
  <option value="0"  >Select Frequency</option>
  
<option value="1" <?php if($getRssDetailsResults[0]["freq_id"] == 1){  print "Selected"; }?> >Every hour</option>
<option value="2" <?php if($getRssDetailsResults[0]["freq_id"] == 2)  {print "Selected"; }?>>Every 2 hours</option>
<option value="3" <?php if($getRssDetailsResults[0]["freq_id"] == 3)  {print "Selected";}?>>Every 3 hours</option>
<option value="6" <?php if($getRssDetailsResults[0]["freq_id"] == 6) { print "Selected";}?>>Every 6 hours</option>
<option value="12" <?php if($getRssDetailsResults[0]["freq_id"] == 12) { print "Selected";}?>>Every 12 hours</option>
<option value="24" <?php if($getRssDetailsResults[0]["freq_id"] == 24){  print "Selected";} ?>>Every 24 hours</option></select>


<h4> Post Content </h4>
Include <select id="feed_showdesc" name="showdesc">

<option value="22"  >Select Post Content</option>


<option value="0" <?php if($getRssDetailsResults[0]["showdesc"] == 0){  print "Selected";} ?>>title only</option>
<option value="1"  <?php if($getRssDetailsResults[0]["showdesc"] == 1){  print "Selected";} ?>>title &amp; description</option>
<option value="2" <?php if($getRssDetailsResults[0]["showdesc"] == 2){  print "Selected";} ?>>description only</option></select>
 <input type="submit" class="submit button" id="xx"  name="submit" value="Update"  />
 
</form>



<?php
include "../includes/footer.php";
}
else
{
	
	Header("Location:../index.php");
	
	
}
?>