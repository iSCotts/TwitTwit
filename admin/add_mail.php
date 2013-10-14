<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
	$GetErrorCode = $_REQUEST["act"];
	if($GetErrorCode == 3)
	$ErrorMessage = "Mail send successfully";
	// Insert Package area
	if(isset($_REQUEST["Send"]) && $_REQUEST["Send"] == "Send"){
	if($_REQUEST["toBox"]<>"")
	{
		if($_REQUEST["seltemplate"]<>"")
		{
		$mailarray=$_REQUEST["toBox"];
		$subject="Sub : ".$_REQUEST["seltemplate"];	
		$tempfile=$_REQUEST["seltemplate"];	
		foreach($mailarray as $mailto)
		{
			$toname2=explode("@",$mailto);
			$toname=$toname2[0];
			$mcontent="";
			$sql3 =  "SELECT * FROM ta_email_template WHERE t_name='$tempfile'  and status='Active'";
			$gettempdetails3 = runQuery($sql3);
				if(file_exists("../mailtempl/".$gettempdetails3[0]["t_file"]))
					{
					//Output a line of the file until the end is reached
								if($_REQUEST["mailtype"]=="HTML")
								{
									$file = fopen("../mailtempl/".$gettempdetails3[0]["t_file"], "r") or exit("Unable to open file!");
									$mcontent="<table><tr><td>Dear {$toname}, </td></tr>";
									while(!feof($file))
									  {
									 $mcontent.="<tr><td>".fgets($file)."</td></tr>";
									  }
									 $mcontent.="</table>";
									 fclose($file);
								}
							else{
								$file2 = fopen("../mailtempl/".$gettempdetails3[0]["t_file"], "r") or exit("Unable to open file!");
								$mcontent="Dear {$toname},\n"; 
								while(!feof($file2))
								{
									 $mcontent.=fgets($file2);
								}
								 fclose($file2);
							  }
					}
		//for sending mail
		$headers = 'From:admin@twitjix.com'."\r\n" .
		'Reply-To: admin@twitjix.com'."\r\n" .
		 'X-Mailer: PHP/'.phpversion();
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$body=$mcontent;
		mail($mailto, $subject, $body, $headers);
			}
			header("Location:add_mail.php?act=3");
						//$ErrorMessage = "Some problem while sending mails";
			}
		else{
			$ErrorMessage = "Please select a template";
		    }
		}
		else{
			$ErrorMessage = "Please select atleast one user";
		}
	}
	// Insert Package area
?>

<style type="text/css">
	.multipleSelectBoxControl span{	/* Labels above select boxes*/
		font-family:arial;
		font-size:11px;
		font-weight:bold;
	}
	.multipleSelectBoxControl div select{	/* Select box layout */
		font-family:arial;
		height:100%;
	}
	.multipleSelectBoxControl input{	/* Small butons */
		width:25px;	
	}
	
	.multipleSelectBoxControl div{
		float:left;
	}
	</style>
	<script type="text/javascript">
		
	var fromBoxArray = new Array();
	var toBoxArray = new Array();
	var selectBoxIndex = 0;
	var arrayOfItemsToSelect = new Array();
	function moveSingleElement()
	{
		var selectBoxIndex = this.parentNode.parentNode.id.replace(/[^\d]/g,'');
		var tmpFromBox;
		var tmpToBox;
		if(this.tagName.toLowerCase()=='select'){			
			tmpFromBox = this;
			if(tmpFromBox==fromBoxArray[selectBoxIndex])tmpToBox = toBoxArray[selectBoxIndex]; else tmpToBox = fromBoxArray[selectBoxIndex];
		}else{
		
			if(this.value.indexOf('>')>=0){
				tmpFromBox = fromBoxArray[selectBoxIndex];
				tmpToBox = toBoxArray[selectBoxIndex];			
			}else{
				tmpFromBox = toBoxArray[selectBoxIndex];
				tmpToBox = fromBoxArray[selectBoxIndex];	
			}
		}
		
		for(var no=0;no<tmpFromBox.options.length;no++){
			if(tmpFromBox.options[no].selected){
				tmpFromBox.options[no].selected = false;
				tmpToBox.options[tmpToBox.options.length] = new Option(tmpFromBox.options[no].text,tmpFromBox.options[no].value);
				
				for(var no2=no;no2<(tmpFromBox.options.length-1);no2++){
					tmpFromBox.options[no2].value = tmpFromBox.options[no2+1].value;
					tmpFromBox.options[no2].text = tmpFromBox.options[no2+1].text;
					tmpFromBox.options[no2].selected = tmpFromBox.options[no2+1].selected;
				}
				no = no -1;
				tmpFromBox.options.length = tmpFromBox.options.length-1;
											
			}			
		}
		
		
		var tmpTextArray = new Array();
		for(var no=0;no<tmpFromBox.options.length;no++){
			tmpTextArray.push(tmpFromBox.options[no].text + '___' + tmpFromBox.options[no].value);			
		}
		tmpTextArray.sort();
		var tmpTextArray2 = new Array();
		for(var no=0;no<tmpToBox.options.length;no++){
			tmpTextArray2.push(tmpToBox.options[no].text + '___' + tmpToBox.options[no].value);			
		}		
		tmpTextArray2.sort();
		
		for(var no=0;no<tmpTextArray.length;no++){
			var items = tmpTextArray[no].split('___');
			tmpFromBox.options[no] = new Option(items[0],items[1]);
			
		}		
		
		for(var no=0;no<tmpTextArray2.length;no++){
			var items = tmpTextArray2[no].split('___');
			tmpToBox.options[no] = new Option(items[0],items[1]);			
		}
	}
	
	function sortAllElement(boxRef)
	{
		var tmpTextArray2 = new Array();
		for(var no=0;no<boxRef.options.length;no++){
			tmpTextArray2.push(boxRef.options[no].text + '___' + boxRef.options[no].value);			
		}		
		tmpTextArray2.sort();		
		for(var no=0;no<tmpTextArray2.length;no++){
			var items = tmpTextArray2[no].split('___');
			boxRef.options[no] = new Option(items[0],items[1]);			
		}		
		
	}
	function moveAllElements()
	{
		var selectBoxIndex = this.parentNode.parentNode.id.replace(/[^\d]/g,'');
		var tmpFromBox;
		var tmpToBox;		
		if(this.value.indexOf('>')>=0){
			tmpFromBox = fromBoxArray[selectBoxIndex];
			tmpToBox = toBoxArray[selectBoxIndex];			
		}else{
			tmpFromBox = toBoxArray[selectBoxIndex];
			tmpToBox = fromBoxArray[selectBoxIndex];	
		}
		
		for(var no=0;no<tmpFromBox.options.length;no++){
			tmpToBox.options[tmpToBox.options.length] = new Option(tmpFromBox.options[no].text,tmpFromBox.options[no].value);			
		}	
		
		tmpFromBox.options.length=0;
		sortAllElement(tmpToBox);
		
	}
	
	
	/* This function highlights options in the "to-boxes". It is needed if the values should be remembered after submit. Call this function onsubmit for your form */
	function multipleSelectOnSubmit()
	{
		
		for(var no=0;no<arrayOfItemsToSelect.length;no++){
			var obj = arrayOfItemsToSelect[no];
			for(var no2=0;no2<obj.options.length;no2++){
				obj.options[no2].selected = true;
			}
		}
		
	}
	
	function createMovableOptions(fromBox,toBox,totalWidth,totalHeight,labelLeft,labelRight)
	{		
		fromObj = document.getElementById(fromBox);
		toObj = document.getElementById(toBox);
		
		arrayOfItemsToSelect[arrayOfItemsToSelect.length] = toObj;

		
		fromObj.ondblclick = moveSingleElement;
		toObj.ondblclick = moveSingleElement;

		
		fromBoxArray.push(fromObj);
		toBoxArray.push(toObj);
		
		var parentEl = fromObj.parentNode;
		
		var parentDiv = document.createElement('DIV');
		parentDiv.className='multipleSelectBoxControl';
		parentDiv.id = 'selectBoxGroup' + selectBoxIndex;
		parentDiv.style.width = totalWidth + 'px';
		parentDiv.style.height = totalHeight + 'px';
		parentEl.insertBefore(parentDiv,fromObj);
		
		
		var subDiv = document.createElement('DIV');
		subDiv.style.width = (Math.floor(totalWidth/2) - 15) + 'px';
		fromObj.style.width = (Math.floor(totalWidth/2) - 15) + 'px';

		var label = document.createElement('SPAN');
		label.innerHTML = labelLeft;
		subDiv.appendChild(label);
		
		subDiv.appendChild(fromObj);
		subDiv.className = 'multipleSelectBoxDiv';
		parentDiv.appendChild(subDiv);
		
		
		var buttonDiv = document.createElement('DIV');
		buttonDiv.style.verticalAlign = 'middle';
		buttonDiv.style.paddingTop = (totalHeight/2) - 50 + 'px';
		buttonDiv.style.width = '30px';
		buttonDiv.style.textAlign = 'center';
		parentDiv.appendChild(buttonDiv);
		
		var buttonRight = document.createElement('INPUT');
		buttonRight.type='button';
		buttonRight.value = '>';
		buttonDiv.appendChild(buttonRight);	
		buttonRight.onclick = moveSingleElement;	
		
		var buttonAllRight = document.createElement('INPUT');
		buttonAllRight.type='button';
		buttonAllRight.value = '>>';
		buttonAllRight.onclick = moveAllElements;
		buttonDiv.appendChild(buttonAllRight);		
		
		var buttonLeft = document.createElement('INPUT');
		buttonLeft.style.marginTop='10px';
		buttonLeft.type='button';
		buttonLeft.value = '<';
		buttonLeft.onclick = moveSingleElement;
		buttonDiv.appendChild(buttonLeft);		
		
		var buttonAllLeft = document.createElement('INPUT');
		buttonAllLeft.type='button';
		buttonAllLeft.value = '<<';
		buttonAllLeft.onclick = moveAllElements;
		buttonDiv.appendChild(buttonAllLeft);
		
		var subDiv = document.createElement('DIV');
		subDiv.style.width = (Math.floor(totalWidth/2) - 15) + 'px';
		toObj.style.width = (Math.floor(totalWidth/2) - 15) + 'px';

		var label = document.createElement('SPAN');
		label.innerHTML = labelRight;
		subDiv.appendChild(label);
				
		subDiv.appendChild(toObj);
		parentDiv.appendChild(subDiv);		
		
		toObj.style.height = (totalHeight - label.offsetHeight) + 'px';
		fromObj.style.height = (totalHeight - label.offsetHeight) + 'px';

			
		selectBoxIndex++;
		
	}
	
	</script>	
	
<td height="380" align="center" valign="top">
<form name="addmail" id="addmail" action="add_mail.php"
	method="post" onsubmit="multipleSelectOnSubmit()">
<table cellpadding="2" cellspacing="2" border="0">
<tr>
		<td colspan="2" align="center">Send Mail</td>
	</tr>
	<tr>
		<td colspan="2" align="center" style="color:#ff0000"><?php print $ErrorMessage ?></td>
	</tr>
	<tr>
		<td>Select Template</td>
		<td>
		<?php
		// get all templates frm emailTemplates table 
  $getTempl = "SELECT * FROM ta_email_template WHERE status='Active'";
  $getTemplresult = runQuery($getTempl);
  ?>
  <select name="seltemplate" id="seltemplate">
  <?php		
  if(count($getTemplresult) >=1 )
  {	
	for($y=0;$y<count($getTemplresult);$y++){
		?>
		<option value="<?php echo $getTemplresult[$y]['t_name'];?>"><?php echo $getTemplresult[$y]['t_name'];?></option>
		<?php }
		}?>
		</select></td>
	</tr>
	<tr>
		<td valign="top">Select Users</td>
		<td>
			<?php
		// get all templates frm emailTemplates table 
  $getUser = "SELECT * FROM ta_user_subscriptions";
  $getUserresult = runQuery($getUser);
  ?>
  <select multiple name="fromBox" id="fromBox">
  <?php		
  if(count($getUserresult) >=1 )
  {	
	for($y=0;$y<count($getUserresult);$y++){
		?>
			<option value="<?php echo $getUserresult[$y]['Email'];?>"><?php echo $getUserresult[$y]['UserName'];?></option>
		<?php }
		}?>
		</select>

<select multiple name="toBox[]" id="toBox">
</select>
<script type="text/javascript">
createMovableOptions("fromBox","toBox",300,200,'All Users','Selected Users');
</script>

	</td>
	</tr>
	<tr>
		<td>Select Mail Type</td>
		<td>
  <select name="mailtype" id="mailtype">
  <option value="Text">Text</option>
   <option value="HTML">HTML</option>
   </select>
   </td>
	</tr>
	<tr>
	<td colspan="2" align="center"><input type="submit" name="Send"
			id="Send" value="Send"/></td>
	</tr>
</table>
</form>
</td>
</tr>
	<?php
	include "includes/footer.php";
	?>


	<?php
}
else
{
	header("Location:index.php?act=3");
	exit;
}

?>