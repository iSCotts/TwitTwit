<?php include "includes/header.php"; ?>	<!-- Middle Content Area Start -->	<div class="middle_main">		<div class="bx_top"><div class="clear"></div></div>		<div class="bx_mid">			<div class="middle_cont">				<!-- Middle Contents Start -->								<div><h1>FAQ</h1></div>								<div class="middlecont_01">					

<div class="features_inner">

<script type="text/javascript">
var faq_slideSpeed = 10;	// Higher value = faster
var faq_timer = 10;	// Lower value = faster

var objectIdToSlideDown = false;
var faq_activeId = false;
var faq_slideInProgress = false;
function showHideContent(e,inputId)
{
	if(faq_slideInProgress)return;
	faq_slideInProgress = true;
	if(!inputId)inputId = this.id;
	inputId = inputId + '';
	var numericId = inputId.replace(/[^0-9]/g,'');
	var answerDiv = document.getElementById('faq_a' + numericId);

	objectIdToSlideDown = false;
	
	if(!answerDiv.style.display || answerDiv.style.display=='none'){		
		if(faq_activeId &&  faq_activeId!=numericId){			
			objectIdToSlideDown = numericId;
			slideContent(faq_activeId,(faq_slideSpeed*-1));
		}else{
			
			answerDiv.style.display='block';
			answerDiv.style.visibility = 'visible';
			
			slideContent(numericId,faq_slideSpeed);
		}
	}else{
		slideContent(numericId,(faq_slideSpeed*-1));
		faq_activeId = false;
	}	
}

function slideContent(inputId,direction)
{
	
	var obj =document.getElementById('faq_a' + inputId);
	var contentObj = document.getElementById('faq_ac' + inputId);
	height = obj.clientHeight;
	if(height==0)height = obj.offsetHeight;
	height = height + direction;
	rerunFunction = true;
	if(height>contentObj.offsetHeight){
		height = contentObj.offsetHeight;
		rerunFunction = false;
	}
	if(height<=1){
		height = 1;
		rerunFunction = false;
	}

	obj.style.height = height + 'px';
	var topPos = height - contentObj.offsetHeight;
	if(topPos>0)topPos=0;
	contentObj.style.top = topPos + 'px';
	if(rerunFunction){
		setTimeout('slideContent(' + inputId + ',' + direction + ')',faq_timer);
	}else{
		if(height<=1){
			obj.style.display='none'; 
			if(objectIdToSlideDown && objectIdToSlideDown!=inputId){
				document.getElementById('faq_a' + objectIdToSlideDown).style.display='block';
				document.getElementById('faq_a' + objectIdToSlideDown).style.visibility='visible';
				slideContent(objectIdToSlideDown,faq_slideSpeed);				
			}else{
				faq_slideInProgress = false;
			}
		}else{
			faq_activeId = inputId;
			faq_slideInProgress = false;
		}
	}
}



function initShowHideDivs()
{
	var divs = document.getElementsByTagName('DIV');
	var divCounter = 1;
	for(var no=0;no<divs.length;no++){
		if(divs[no].className=='faq_question'){
			divs[no].onclick = showHideContent;
			divs[no].id = 'faq_q'+divCounter;
			var answer = divs[no].nextSibling;
			while(answer && answer.tagName!='DIV'){
				answer = answer.nextSibling;
			}
			answer.id = 'faq_a'+divCounter;	
			contentDiv = answer.getElementsByTagName('DIV')[0];
			contentDiv.style.top = 0 - contentDiv.offsetHeight + 'px'; 	
			contentDiv.className='faq_answer_content';
			contentDiv.id = 'faq_ac' + divCounter;
			answer.style.display='none';
			answer.style.height='1px';
			divCounter++;
		}		
	}	
}
window.onload = initShowHideDivs;
</script>


<div class="faq_question">What is TwitACC ?</div>
<div class="faq_answer">
	<div>
		We track which twitter users are using the keywords you choose and provide you with a convenient way to follow them. The benefits are: more targeted followers, market to people who are interested, or just more friends.
	</div>
</div>	

<div class="faq_question">How to pay using credit card ?</div>
<div class="faq_answer">
	<div>
		You can use your credit card on paypal without creating a paypal account. Look for "Don't have a PayPal account? Use your credit card or bank account (where available)." on the paypal pages
	</div>
</div>	


<div class="faq_question">Why i can't follow more than 2000 people ?</div>
<div class="faq_answer">
	<div>
		This happens to random twitter accounts. Once the following/follower ratio is closer to 1/1 you'll be able to go beyond 2000 followings. User our unfollow tool to unfollow people who aren't following you back
	</div>
</div>	

<div class="faq_question">Do you store my twitter passwords on twitjix.com ?</div>
<div class="faq_answer">
	<div>
		No, We dont store your twitter passwords or any other sensitive account information. We use a mechanism called OAuth to authenticate you directly on twitter.com using a secure connection.
	</div>
</div>	

<div class="faq_question">Can i spam twitter ?</div>
<div class="faq_answer">
	<div>
		It certainly isn't ok to spam twitter. So you can't just follow random people .
	</div>
</div>

<div class="faq_question">How do I upgrade my account ?</div>
<div class="faq_answer">
	<div>
		Login to Twitacc then click on the upgrade Link
	</div>
</div>	

<div style="height:40px;">&nbsp;</div>



				</div>									</div>												<!-- Middle Contents End -->			</div>		</div>	</div>	<!-- Middle Content Area End -->	<?php include "includes/footer.php";?>	