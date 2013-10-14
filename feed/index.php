<?php
session_start();
/*
 * Created on 28-Dec-2009
 *
 * Author :	root
 * File:	feed.php
 *
 */
session_start();
?>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
 <form action="feed.php" method="post">

<!--<h4 style="font-weight: 100; margin-bottom: 10px;">Twitter Name</h4>
<input id="feed_username" name="username" size="20" value="" type="text"/>-->

 
<h4 style="font-weight: 100; margin-bottom: 10px;">Feed Name</h4>
<input id="feed_feedname" name="feedname" size="20" value="" type="text"/>
<h4 style="font-weight: 100; margin-bottom: 10px;">RSS Feed URL</h4>
<input id="feed_feedurl" name="feedurl" size="70" value="" type="text"/>
       <a class="rss_btn" href="#" onclick="checkURL()">
       test rss feed</a>
<div id='feed_urlstatus'></div>
<input name="isactive" value="0" type="hidden"><input checked="checked" id="feed_isactive" name="isactive" value="1" type="checkbox"/> <label for="feed_isactive" style="float: none;">Active</label>
<br/>
ADVANCE SETTING

<input type="hidden" name="susername" value="<?php print $_SESSION["username"]?>">
<h4> Sort  Id </h4>
   <select id="sortid" name="sortid">
<option value="1" selected="selected">PubDate</option>
<option value="2">guid</option>
 </select>


 <h4> Update Frequency </h4>
  Check for new posts <select id="feed_freq_id" name="freq_id">
<option value="1" selected="selected">Every hour</option>
<option value="2">Every 2 hours</option>
<option value="3">Every 3 hours</option>
<option value="6">Every 6 hours</option>
<option value="12">Every 12 hours</option>
<option value="24">Every 24 hours</option></select>


<h4> Post Content </h4>
Include <select id="feed_showdesc" name="showdesc">
<option value="0">title only</option>
<option value="1" selected="selected">title &amp; description</option>
<option value="2">description only</option></select>
<input type="submit" class="submit button" name="submit" value="Submit" />
</form>