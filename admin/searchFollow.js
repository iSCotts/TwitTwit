function submitDetails(){
	var addkeyword = $('#addkeyword').attr('value');
	var	type = $('#type').attr('value');
	var	count = $('#count').attr('value');
	var	lang = $('#lang').attr('value');
	var	CampaignID = $('#CampaignID').attr('value');
	var	name = $('#usersList1').attr('value');
	var	id = $('#id').attr('value');
		$.ajax({
			type: "POST",
			url: "../searchFollow/addkeyword.php",
			cache: false,
			data: "addkeyword="+ addkeyword + "&type="+ type + "&count="+ count + "&lang="+ lang + "&name="+ name + "&id="+ id + "&CampaignID="+ CampaignID,
			success: function(html){
				$("#tlerror").remove();
				$("#tlTable").append(html);
				$('#addkeyword').val("");
						}
		});
	}
function followstatus(status,name,spanid,user,campainID,message,keyID){
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
					$("#followcount"+message).html(result);
				}
			});
			
		}
	});
	
}
function listFollowers(type,message,campainID,name,keyID){
	var spanid="#"+message +"_following";
	var countid="#"+message +"counter";
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
	var spanid="#"+message +"_following";
	var countid="#"+message +"counter";
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
	if(confirm('Are you sure you want to remove '+ message) == false) {
		return false;
	}
	$.ajax({
		type: "POST",
		url: "../searchFollow/removeKey.php",
		cache: false,
		data: "campainID="+campainID+"&message="+message,
		success: function(html){
			$("#tr"+message+"1").remove(),
			$("#tr"+message+"2").remove(),
			$("#tr"+message+"3").remove(),
			$("#tr"+message+"4").remove(),
			$("#tlerror").remove();
		}
	});
}
function pausePlay(campainID,message,status){
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
			$("#pausePlay"+message).html(html);
			
		}
	});
}
function userlist(CampaignID,count){
	var id='usersList'+count;
	var usersList=document.getElementById(id).value;
	if(usersList==0){
		alert("Select User");
		return false;
	}
	$.ajax({
		type: "POST",
		url: "../searchFollow/main.php",
		cache: false,
		data: "username="+usersList+"&CampaignID="+CampaignID,
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


function ShowUsersList(v){
//var	user = $('#name').attr('value');
//	var	campainID = $('#name1').attr('value');
	var	campainID =v;
	//alert(campainID);
	$("#name1").autocomplete("userList123.php", {
		extraParams: { campaignId:campainID },
		cacheLength:1,
		delay:5,
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