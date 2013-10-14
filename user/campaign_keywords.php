	<!-- Add Keywords Form Start -->
						<div class="cont_form_inner" id="keywords" style="display: none;">
						<?php 
						$campaignID=$_SESSION["SCampaignId"];
							?>
						<div style="text-align:right; padding:0 60px 0 0;">
						 
							Select User <select  class="inner_option_medium01" id="usersList1" name="usersList1" onchange="userlist('<?php echo $campaignID?>','1',this.value);">
							<?php

								echo "<option value=\"0\">Select User</option>";
								for ($i = 0; $i < $userNamesCount; $i++) {
									echo "<option value=\"{$userNames[$i]}\">{$userNames[$i]}</option>";
								}
							?>
							</select></div>
						<div id ="usersListDiv1"></div>

						</div>
						<!-- Add Keywords Form End -->

