function dkRegisterKeywordNotification(obj,username,id)
{
	var	notify_status = 'no';
	var	notify_frequency = $('#notify_frequency_'+id).attr('value');
	if(obj.checked)
	{
		notify_status = 'yes';
	}
	var query_string = "name="+username+"&act=1&id="+id+"&notify_status="+notify_status+"&notify_frequency="+notify_frequency;
	$.ajax({
		type: "POST",
		url: "../searchFollow/keyword_notify_settings.php",
		cache: false,
		data: query_string,
		success: function(result){
			var rtemp = result.split('|brk|');
			if(rtemp.length >2)
			{
				if(rtemp[1]=='get_email' && obj.checked)
				{
					dkUpdateUserEmail(username);
				}
				else if(rtemp[1]=='ok')
				{
					//alert('Keyword notification updated');
				}
			}
		}
	});
}
function dkChangeNotifyFrequency(username,id)
{
	var	notify_frequency = $('#notify_frequency_'+id).attr('value');
	var query_string = "name="+username+"&act=2&id="+id+"&notify_frequency="+notify_frequency;
	$.ajax({
		type: "POST",
		url: "../searchFollow/keyword_notify_settings.php",
		cache: false,
		data: query_string,
		success: function(result){
			var rtemp = result.split('|brk|');
			if(rtemp.length >2)
			{
				if(rtemp[1]=='get_email' && obj.checked)
				{
					dkUpdateUserEmail(username);
				}
				else if(rtemp[1]=='ok')
				{
					//alert('Keyword notification frequency updated');
				}
			}
		}
	});
}
function dkUpdateUserEmail(username)
{
	var email=prompt("Please enter your email","");
	if(email != null)
	{
		while(!dkEmailIdCheck(email))
		{
			email=prompt("Please enter your vaild email",email);
		}
		if(dkEmailIdCheck(email))
		{
			var query_string = "name="+username+"&act=3"+"&new_email="+email;
			$.ajax({
				type: "POST",
				url: "../searchFollow/keyword_notify_settings.php",
				cache: false,
				data: query_string,
				success: function(result){
					alert('You email address updated');
				}
			});
		}
	}
}
var allPageTags = new Array(); 
function dkShortKeys()
{
/*	
	jQuery(document).bind('keydown', 'Shift+a',function (evt){
	var allPageTags=document.getElementsByTagName("input");
	for (i=0; i<allPageTags.length; i++) 
	{
		if (allPageTags[i].name=='follow_user' || allPageTags[i].name=='block_user' || allPageTags[i].name=='remove_user'  ||  allPageTags[i].name=='unfollow_user' || allPageTags[i].name=='unblock_user' ) 
		{
			allPageTags[i].checked='checked';
		}
	}
	return false;
	});
	jQuery(document).bind('keydown', 'Shift+r',function (evt){
	var allPageTags=document.getElementsByTagName("input");
	for (i=0; i<allPageTags.length; i++) 
	{
		if (allPageTags[i].name=='follow_user' || allPageTags[i].name=='block_user'  || allPageTags[i].name=='remove_user'  ||  allPageTags[i].name=='unfollow_user' || allPageTags[i].name=='unblock_user' ) 
		{
			allPageTags[i].checked='';
		}
	}
	return false;
	});
*/	
	jQuery(document).bind('keydown', 'f2',function (evt){
	var allPageTags=document.getElementsByTagName("input");
	for (i=0; i<allPageTags.length; i++) 
	{
		if (allPageTags[i].name=='follow_user' || allPageTags[i].name=='remove_user' ||  allPageTags[i].name=='unfollow_user') 
		{
			allPageTags[i].checked='checked';
		}
		else if (allPageTags[i].name=='block_user' || allPageTags[i].name=='unblock_user'  ) 
		{
			allPageTags[i].checked='';
		}
	}
	return false;
	});
	jQuery(document).bind('keydown', 'Shift+f2',function (evt){
	var allPageTags=document.getElementsByTagName("input");
	for (i=0; i<allPageTags.length; i++) 
	{
		if (allPageTags[i].name=='follow_user' || allPageTags[i].name=='remove_user'  ||  allPageTags[i].name=='unfollow_user' ) 
		{
			allPageTags[i].checked='';
		}
	}
	return false;
	});
	jQuery(document).bind('keydown', 'f4',function (evt){
	var allPageTags=document.getElementsByTagName("input");
	for (i=0; i<allPageTags.length; i++) 
	{
		if (allPageTags[i].name=='block_user' || allPageTags[i].name=='unblock_user'  ) 
		{
			allPageTags[i].checked='checked';
		}
		else if (allPageTags[i].name=='follow_user' || allPageTags[i].name=='remove_user'  ||  allPageTags[i].name=='unfollow_user' ) 
		{
			allPageTags[i].checked='';
		}
	}
	return false;
	});
	jQuery(document).bind('keydown', 'Shift+f4',function (evt){
	var allPageTags=document.getElementsByTagName("input");
	for (i=0; i<allPageTags.length; i++) 
	{
		if (allPageTags[i].name=='block_user' || allPageTags[i].name=='unblock_user'  ) 
		{
			allPageTags[i].checked='';
		}
	}
	return false;
	});
}
//jQuery(document).ready(dkShortKeys); // this function call moved to campaign.php 
//Create an array 
function dkClearDivWithClassName(theClass) 
{
	//Populate the array with all the page tags
	var allPageTags=document.getElementsByTagName("div");
	//Cycle through the tags using a for loop
	for (i=0; i<allPageTags.length; i++) 
	{
		//Pick out the tags with our class name
		if (allPageTags[i].className==theClass) 
		{
			//Manipulate this in whatever way you want
			//allPageTags[i].style.display='none';
			allPageTags[i].innerHTML='';
		}
	}
	var allPageTags=document.getElementsByTagName("a");
	for (i=0; i<allPageTags.length; i++) 
	{
		if (allPageTags[i].name=='dk_keyword_info') 
		{
			allPageTags[i].style.color='#193842';
		}
	}
} 
function dkListFollowed(pageno,message,name,keyID,act,followed_user,kid)
{
	var query_string = "name="+name+"&keyID="+keyID+"&pageno="+pageno+"&message="+message+"&act="+act+"&followed_user="+followed_user+"&kid="+kid;
	var km_ids = '';
/*	if(act == 'unfollow')
	{
		if(document.suggesions_form.unfollow_user.length)
		{
			for (var i=0; i < document.suggesions_form.unfollow_user.length; i++)
			   {
			   if (document.suggesions_form.unfollow_user[i].checked)
				  {
					  if(km_ids == '')
					  {
						 km_ids= document.suggesions_form.unfollow_user[i].value;
					  }
					  else
					  {
						 km_ids+= ','+ document.suggesions_form.unfollow_user[i].value;
					  }
				  }
			   }
		}
		else
		{
			km_ids= document.suggesions_form.unfollow_user.value;
		}
		 if(km_ids == '')
		 {
			 alert('Please check users to be unfollowed.');
			 return false;
		 }
		 else
		 {
			 query_string+= "&km_ids="+km_ids;
		 }
	}*/
	 if(act == 'block')
	{
		if(document.suggesions_form.block_user.length)
		{
			for (var i=0; i < document.suggesions_form.block_user.length; i++)
			   {
			   if (document.suggesions_form.block_user[i].checked)
				  {
					  if(km_ids == '')
					  {
						 km_ids= document.suggesions_form.block_user[i].value;
					  }
					  else
					  {
						 km_ids+= ','+ document.suggesions_form.block_user[i].value;
					  }
				  }
			   }
		}
		else
		{
			km_ids= document.suggesions_form.block_user.value;
		}
		 if(km_ids == '')
		 {
			 alert('Please check users to be unblocked.');
			 return false;
		 }
		 else
		 {
			 query_string+= "&km_ids="+km_ids;
		 }
	}
	dkClearDivWithClassName("suggesions");
	var newmsg=message;
	var newmsg=newmsg.split(' ').join('');
	var spanid="#"+newmsg +"_following";
	var countid="#"+newmsg +"counter";
	var info_id="#tr"+newmsg +"3";
	$(spanid).html('<img src="../images/loading.gif" style="padding-left:340px"/>');
	$.ajax({
		type: "POST",
		url: "../searchFollow/followed.php",
		cache: false,
		data: query_string,
		success: function(result){
			var rtemp = result.split('/break/');
			$(spanid).html(rtemp[0]);
			if(rtemp.length == 2) $(info_id).html(rtemp[1]);
		}
	});
	return false;
}
function dkListBlocked(pageno,message,name,keyID,act)
{
	var query_string = "name="+name+"&keyID="+keyID+"&pageno="+pageno+"&message="+message+"&act="+act;
	var km_ids = '';
	if(act == 'follow')
	{
		if(document.suggesions_form.follow_user.length)
		{
			for (var i=0; i < document.suggesions_form.follow_user.length; i++)
			   {
			   if (document.suggesions_form.follow_user[i].checked)
				  {
					  if(km_ids == '')
					  {
						 km_ids= document.suggesions_form.follow_user[i].value;
					  }
					  else
					  {
						 km_ids+= ','+ document.suggesions_form.follow_user[i].value;
					  }
				  }
			   }
		}
		else
		{
			km_ids= document.suggesions_form.follow_user.value;
		}
		 if(km_ids == '')
		 {
			 alert('Please check users to be followed.');
			 return false;
		 }
		 else
		 {
			 query_string+= "&km_ids="+km_ids;
		 }
	}
	else if(act == 'unblock')
	{
		if(document.suggesions_form.unblock_user.length)
		{
			for (var i=0; i < document.suggesions_form.unblock_user.length; i++)
			   {
			   if (document.suggesions_form.unblock_user[i].checked)
				  {
					  if(km_ids == '')
					  {
						 km_ids= document.suggesions_form.unblock_user[i].value;
					  }
					  else
					  {
						 km_ids+= ','+ document.suggesions_form.unblock_user[i].value;
					  }
				  }
			   }
		}
		else
		{
			km_ids= document.suggesions_form.unblock_user.value;
		}
		 if(km_ids == '')
		 {
			 alert('Please check users to be unblocked.');
			 return false;
		 }
		 else
		 {
			 query_string+= "&km_ids="+km_ids;
		 }
	}
	dkClearDivWithClassName("suggesions");
	var newmsg=message;
	var newmsg=newmsg.split(' ').join('');
	var spanid="#"+newmsg +"_following";
	var countid="#"+newmsg +"counter";
	var info_id="#tr"+newmsg +"3";
	$(spanid).html('<img src="../images/loading.gif" style="padding-left:340px"/>');
	$.ajax({
		type: "POST",
		url: "../searchFollow/blocked.php",
		cache: false,
		data: query_string,
		success: function(result){
			var rtemp = result.split('/break/');
			$(spanid).html(rtemp[0]);
			if(rtemp.length == 2) $(info_id).html(rtemp[1]);
		}
	});
	return false;
}
function dkListQueued(pageno,message,name,keyID,act)
{
	var query_string = "name="+name+"&keyID="+keyID+"&pageno="+pageno+"&message="+message+"&act="+act;
	var km_ids = '';
	if(act == 'remove')
	{
		if(document.suggesions_form.remove_user.length)
		{
		for (var i=0; i < document.suggesions_form.remove_user.length; i++)
		   {
		   if (document.suggesions_form.remove_user[i].checked)
			  {
				  if(km_ids == '')
				  {
			 		 km_ids= document.suggesions_form.remove_user[i].value;
				  }
				  else
				  {
			 		 km_ids+= ','+ document.suggesions_form.remove_user[i].value;
				  }
			  }
		   }
		}
		else
		{
			km_ids= document.suggesions_form.remove_user.value;
		}
		 if(km_ids == '')
		 {
			 alert('Please check users to be removed.');
			 return false;
		 }
		 else
		 {
			 query_string+= "&km_ids="+km_ids;
		 }
	}
	else if(act == 'block')
	{
		if(document.suggesions_form.block_user.length)
		{
			for (var i=0; i < document.suggesions_form.block_user.length; i++)
			   {
			   if (document.suggesions_form.block_user[i].checked)
				  {
					  if(km_ids == '')
					  {
						 km_ids= document.suggesions_form.block_user[i].value;
					  }
					  else
					  {
						 km_ids+= ','+ document.suggesions_form.block_user[i].value;
					  }
				  }
			   }
		}
		else
		{
			km_ids= document.suggesions_form.block_user.value;
		}
		 if(km_ids == '')
		 {
			 alert('Please check users to be blocked.');
			 return false;
		 }
		 else
		 {
			 query_string+= "&km_ids="+km_ids;
		 }
	}
	dkClearDivWithClassName("suggesions");
	var newmsg=message;
	var newmsg=newmsg.split(' ').join('');
	var spanid="#"+newmsg +"_following";
	var countid="#"+newmsg +"counter";
	var info_id="#tr"+newmsg +"3";
	$(spanid).html('<img src="../images/loading.gif" style="padding-left:340px"/>');
	$.ajax({
		type: "POST",
		url: "../searchFollow/queued.php",
		cache: false,
		data: query_string,
		success: function(result){
			var rtemp = result.split('/break/');
			$(spanid).html(rtemp[0]);
			if(rtemp.length == 2) $(info_id).html(rtemp[1]);
		}
	});
	return false;
}
function dkListSuggestions(pageno,message,name,keyID,act)
{
	var query_string = "name="+name+"&keyID="+keyID+"&pageno="+pageno+"&message="+message+"&act="+act;
	var km_ids = '';
	if(act == 'follow')
	{
		if(document.suggesions_form.follow_user.length)
		{
			for (var i=0; i < document.suggesions_form.follow_user.length; i++)
			   {
			   if (document.suggesions_form.follow_user[i].checked)
				  {
					  if(km_ids == '')
					  {
						 km_ids= document.suggesions_form.follow_user[i].value;
					  }
					  else
					  {
						 km_ids+= ','+ document.suggesions_form.follow_user[i].value;
					  }
				  }
			   }
		}
		else
		{
			km_ids= document.suggesions_form.follow_user.value;
		}
		 if(km_ids == '')
		 {
			 alert('Please check users to be followed.');
			 return false;
		 }
		 else
		 {
			 query_string+= "&km_ids="+km_ids;
		 }
	}
	else if(act == 'block')
	{
		if(document.suggesions_form.block_user.length)
		{
			for (var i=0; i < document.suggesions_form.block_user.length; i++)
			   {
			   if (document.suggesions_form.block_user[i].checked)
				  {
					  if(km_ids == '')
					  {
						 km_ids= document.suggesions_form.block_user[i].value;
					  }
					  else
					  {
						 km_ids+= ','+ document.suggesions_form.block_user[i].value;
					  }
				  }
			   }
		}
		else
		{
			km_ids= document.suggesions_form.block_user.value;
		}
		 if(km_ids == '')
		 {
			 alert('Please check users to be blocked.');
			 return false;
		 }
		 else
		 {
			 query_string+= "&km_ids="+km_ids;
		 }
	}
	dkClearDivWithClassName("suggesions");
	var newmsg=message;
	var newmsg=newmsg.split(' ').join('');
	var spanid="#"+newmsg +"_following";
	var countid="#"+newmsg +"counter";
	var info_id="#tr"+newmsg +"3";
	$(spanid).html('<img src="../images/loading.gif" style="padding-left:340px"/>');
	$.ajax({
		type: "POST",
		url: "../searchFollow/suggestions.php",
		cache: false,
		data: query_string,
		success: function(result){
			var rtemp = result.split('/break/');
			$(spanid).html(rtemp[0]);
			if(rtemp.length == 2) $(info_id).html(rtemp[1]);
		}
	});
	return false;
}
function dkEmailIdCheck(email) 
{
		var str=email;
		var at="@";
		var dot=".";
		var lat=str.indexOf(at);
		var lstr=str.length;
		var ldot=str.indexOf(dot);
		if(email == '')
		{
		    return false
		}
		else if (str.indexOf(at)==-1 || str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr || str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr || str.indexOf(at,(lat+1))!=-1 || str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot || str.indexOf(dot,(lat+2))==-1 || str.indexOf(" ")!=-1 )
		{
		   return false
		}
 		else
		{
			return true;
		}
}
function submitDetails(){
	var addkeyword = $('#addkeyword').attr('value');
	var	type = $('#type').attr('value');
	var	count = $('#count').attr('value');
	var	lang = $('#lang').attr('value');
	var	CampaignID = $('#CampaignID').attr('value');
	var	name = $('#usersList1').attr('value');
	var	id = $('#id').attr('value');
	var	uname = $('#uname').attr('value');
	if(addkeyword =='')
	{
		alert('Please enter keyword');
	}
	else
	{
		$.ajax({
			type: "POST",
			url: "../searchFollow/addkeyword.php",
			cache: false,
			data: "addkeyword="+ addkeyword + "&type="+ type + "&count="+ count + "&lang="+ lang + "&name="+ name + "&id="+ id + "&CampaignID="+ CampaignID+ "&uname="+ uname,
			success: function(html){
				var temp = html.split('|brk|');
				if(temp.length > 1)
				{
					if(temp.length == 3)
					{
						$("#tlerror").remove();
						$("#tlTable").append(temp[2]);
						$('#addkeyword').val("");
						if(document.getElementById('error_keyword'))
						{
							document.getElementById('error_keyword').innerHTML = temp[1];
						}
						else
						{
							$("#tlTable").append('<span class="error" id="error_keyword" >'+temp[1]+'</span>');
						}
					}
					else
					{
						$('#addkeyword').val("");
						if(document.getElementById('error_keyword'))
						{
							document.getElementById('error_keyword').innerHTML = temp[1];
						}
						else
						{
							$("#tlTable").append('<span class="error" id="error_keyword" >'+temp[1]+'</span>');
						}
					}

				}
				else
				{
					$("#tlerror").remove();
					$("#tlTable").append(html);
					$('#addkeyword').val("");
					$("#error_keyword").remove();
				}
				
						}
		});
		}
		return false;
	}
function submitTweets(){
	var tweetmsg= $('#tweetstxt').attr('value');
	var name= $('#tweetuser').attr('value');
	if(tweetmsg!="")
	{
	$("#result").html('<img src="../images/loading.gif" style="padding-top:4px;padding-left:30px;"/>')
	
		$.ajax({
			type: "POST",
			url: "../user/post_hometweets.php",
			cache: false,
			data: "tweetmsg="+ tweetmsg + "&name="+ name,
			success: function(result){
		//	$("#result").html(result);
			$('#tweetstxt').val("");
			$.ajax({
				type: "POST",
				url: "../user/get_hometweets.php",
				cache: false,
				data: "&name="+ name,
				success: function(result){
				$("#tweetresult").html(result);
				$('#tweetstxt').val("");
					}
		});
	  }
	});	
	}
	else{
		$("#result").html("Tweet message should not empty !");
	}
}
function gettweets()
{
	$("#tweetresult").html('<img src="../images/loading.gif" style="padding-top:4px;padding-left:30px;"/>')
	var name= $('#tweetuser').attr('value');
	$.ajax({
		type: "POST",
		url: "../user/get_hometweets.php",
		cache: false,
		data: "&name="+ name,
		success: function(result){
		$("#tweetresult").html(result);
				}
});
	
}
function getgroups()
{
	$("#middle_group_rmid01").html('<img src="../images/loading0.gif" style="padding-top:4px;padding-left:30px;"/>')
	var name= $('#tweetuser').attr('value');
	$.ajax({
		type: "POST",
		url: "../user/get_homegroups.php",
		cache: false,
		data: "&name="+ name,
		success: function(result){
		$("#middle_group_rmid01").html(result);
			}
});
}
function followstatus(status,name,spanid,user,campainID,message,keyID){
	var newmsg=message;
	var newmsg=newmsg.split(' ').join('');
	$.ajax({
		url: "../searchFollow/follow.php",
		type: "POST",
		data: "type="+status+"&name="+name+"&message="+message+"&user="+user+"&spanid="+spanid+"&campainID="+campainID+"&keyID="+keyID,
		cache: false,
		success: function(result){
			$("#"+spanid).html(result);
			$.ajax({
				url: "../searchFollow/followStatus.php",
				type: "POST",
				data: "name="+name+"&message="+message+"&campainID="+campainID+"&status="+status+"&keyID="+keyID,
				cache: false,
				success: function(result){
				$("#followcount"+newmsg).html(result);
				}
			});
			
		}
	});
	
}
function listFollowers(type,message,campainID,name,keyID){
	var newmsg=message;
	var newmsg=newmsg.split(' ').join('');
	var spanid="#"+newmsg +"_following";
	var countid="#"+newmsg +"counter";
	$(spanid).html('<img src="../images/loading.gif" style="padding-left:340px"/>');
	$.ajax({
		type: "POST",
		url: "../searchFollow/followingList.php",
		cache: false,
		data: "name="+name+"&keyID="+keyID+"&message="+message+"&campainID="+campainID+"&type="+type,
		success: function(result){
			$(spanid).html(result),
			$(spanid+" tr").quickpaginate({ perpage: 10, showcounter: true, pager : $(countid) });
		}
	});
}
function quickRun(name,keyid,campainID,message){
	var newmsg=message;
	var newmsg=newmsg.split(' ').join('');
	var spanid="#"+newmsg +"_following";
	var countid="#"+newmsg +"counter";
	$(spanid).html('<img src="../images/loading.gif" style="padding-left:340px"/>');
	$.ajax({
			type: "POST",
			url: "../searchFollow/quickRun.php",
			cache: false,
			data: "name="+name+"&keyid="+keyid+"&message="+message+"&campainID="+campainID,
			success: function(html){
				$(spanid).html(html),
				$(spanid+" tr").quickpaginate({ perpage: 10, showcounter: true, pager : $(countid) });
			}
		});
}
function removeKey(campainID,message){
	var newmsg=message;
	var newmsg=newmsg.split(' ').join('');
	if(confirm('Are you sure you want to remove '+ message) == false) {
		return false;
	}
	$.ajax({
		type: "POST",
		url: "../searchFollow/removeKey.php",
		cache: false,
		data: "campainID="+campainID+"&message="+message,
		success: function(html){
			$("#tr"+newmsg+"1").remove(),
			$("#tr"+newmsg+"2").remove(),
			$("#tr"+newmsg+"3").remove(),
			$("#tr"+newmsg+"4").remove(),
			$("#tlerror").remove();
			if(document.getElementById('error_keyword'))
			{
				document.getElementById('error_keyword').innerHTML = '';
			}
		}
	});
	return false;
}
function pausePlay(campainID,message,status){
	var newmsg=message;
	var newmsg=newmsg.split(' ').join('');
	if(confirm('Are you sure you want to  '+status + ' '+ message) == false) {
		return false;
	}
	$.ajax({
		type: "POST",
		url: "../searchFollow/pausePlay.php",
		cache: false,
		data: "campainID="+campainID+"&message="+message,
		success: function(html){
			$("#tlerror").remove();
			$("#pausePlay"+newmsg).html(html);
			
		}
	});
}
function userlist(CampaignID,count,uname){
	var id='usersList'+count;
	var usersList=document.getElementById(id).value;
	if(usersList==0){
		alert("Select User");
		return false;
	}
	$("#usersListDiv"+count).html('<center><img src="../images/loading.gif" style="padding-top:10px"/></center>')
	$.ajax({
		type: "POST",
		url: "../searchFollow/main.php",
		cache: false,
		data: "username="+usersList+"&CampaignID="+CampaignID+"&uname="+uname,
		success: function(html){
			$("#usersListDiv"+count).html(html);
			
		}
	});
}
function  unfollowUser(){
	var	user = $('#course').attr('value');
	var	name = $('#name').attr('value');
	var	campaign = $('#campaign').attr('value');
	$.ajax({
		type: "POST",
		url: "../searchFollow/follow.php",
		cache: false,
		data: "name="+name+"&type=remove&user="+user+"&campainID="+campaign,
		success: function(html){
		$("#usersListDiv").html("Unfollowed The user "+ user);
		initializeTextbox();
		//success: function(result){
		//$("#usersListDiv").html(result);
		//initializeTextbox();
				}
	});
}


function ShowUsersList(){
	//var	user = $('#name').attr('value');
	var	campainID = $('#name1').attr('value');
	$("#name1").autocomplete("../searchFollow/userList123.php", {
		extraParams: { campaignId:campainID },
		cacheLength:1,
		delay:10,
		width: 260,
		max:10,
		matchContains: true,
		selectFirst: false
	});
}






function initializeTextbox(){
	var	user = $('#name').attr('value');
	var	campainID = $('#campaign').attr('value');
	$("#course").autocomplete("../searchFollow/userList.php", {
		extraParams: { userID:user,campaignId:campainID },
		cacheLength:1,
		delay:10,
		width: 260,
		max:10,
		matchContains: true,
		selectFirst: false
	});
}
function changeFollowCount(id,KeyId,campaign,userID){
	var	followCount = $('#'+id).attr('value');
	$.ajax({
		type: "POST",
		url: "../searchFollow/updateFollowCount.php",
		cache: false,
		data: "followCount="+followCount+"&KeyId="+KeyId+"&campainID="+campaign+"&userID="+userID,
	});
}
function groupfollowstatus(status,name,spanid,user){
	  	$.ajax({
		url: "../group/follow.php",
		type: "POST",
		data: "type="+status+"&name="+name+"&user="+user+"&spanid="+spanid,
		cache: false,
		success: function(result){
			$("#"+spanid).html(result);
			}
	});
	
} 
function groupblockuser(blkstatus,flwstatus,name,blkspanid,flwspanid,user,groupid){
	   	$.ajax({
		url: "../group/blockuser.php",
		type: "POST",
		data: "btype="+blkstatus+"&ftype="+flwstatus+"&name="+name+"&user="+user+"&spanid="+blkspanid+"&groupID="+groupid,
		cache: false,
		success: function(result){
   			$("#"+blkspanid).html(result);
			$.ajax({
				url: "../group/follow.php",
				type: "POST",
				data: "btype="+blkstatus+"&type="+flwstatus+"&name="+name+"&user="+user+"&spanid="+flwspanid,
				cache: false,
				success: function(result){
				$("#"+flwspanid).html(result);
				}
			});
				
			}
	});
}
function displayfriends(){
	var	user = $('#username').attr('value');
		$.ajax({
		type: "POST",
		url: "../searchFollow/displayfriends.php",
		cache: false,
		data: "user="+user,
		success: function(result){
		$('#resultdiv').html(result);
			}
	});
}
function showgraph(month,year,user){
	$("#followgraph").html('<img src="../images/loading.gif" style="padding-top:125px"/>')
	var	month = $('#month').attr('value');
	var	year = $('#yearselect').attr('value');
	var	user = $('#user').attr('value');
	$.ajax({
	type: "POST",
		url: "../user/followergraph.php",
		cache: false,
		data: "month="+month,
		success: function(html){
	$("#followgraph").html('<img src="followergraph.php?month='+month+'&yearselect='+year+'&user='+user+'"/>')
		}
	});
}