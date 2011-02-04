<?php
/*!
 * **************************************************************
 ****************  ProQuiz V2.0.0b ******************************
 ***************************************************************/
 /* documentation at: http://proquiz.softon.org/documentation/
 /* Designed & Maintained by
 /*                                    - Softon Technologies
 /* Developer
 /*                                    - Manzovi
 /* For Support Contact @
 /*                                    - proquiz@softon.org
 /* version 2.0.0 beta (2 Feb 2011)
 /* Licensed under GPL license:
 /* http://www.gnu.org/licenses/gpl.html
 */
?><div id="newquiz" style="margin-top: 50px;">
  <form action="<?php echo "functions.php?action=edit_profile&type=".$_GET['type']; ?>" enctype="multipart/form-data" method="post" id="profile_edit">
  <?php if($_GET['type']=='username'){ ?>
   
	<fieldset>
		<legend>Username</legend>
		<ul>
			<li>
				<label for="edit_username"><span class="required">Enter the Username</span></label>
				<input type="text" id="edit_username" name="username" value="<?php echo $_SESSION['UA_DETAILS']['username']; ?>" />
			</li>

		</ul>
	</fieldset>
  <?php }elseif($_GET['type']=='email'){ ?>	
  <fieldset>
		<legend>Email</legend>
		<ul>
			<li>
				<label for="edit_email"><span class="required">Enter Your Email</span></label>
				<input type="text" id="edit_email" name="email" value="<?php echo $_SESSION['UA_DETAILS']['email']; ?>" />
			</li>

		</ul>
	</fieldset>
  
  <?php }elseif($_GET['type']=='password'){ ?>
  <fieldset>
		<legend>Password</legend>
		<ul>
			<li>
				<label for="edit_password"><span class="required">Enter Your Password</span></label>
				<input type="password"  id="edit_password" name="password" value="" />
			</li>
            <li>
				<label for="edit_password"><span class="required">Confirm Your Password</span></label>
				<input type="password"  id="edit_cpassword" name="cpassword" value="" />
			</li>

		</ul>
	</fieldset>
  
  <?php }elseif($_GET['type']=='other'){ ?>
  <fieldset>
		<legend>Profile</legend>
		<ul>
			<li>
				<label for="fname"><span class="required">First Name</span></label>
				<input id="fname" name="fname" class="text required" type="text" value="<?php echo $_SESSION['UA_DETAILS']['fname']; ?>" />
			</li>
            <li>
				<label for="lname"><span class="required">Last Name</span></label>
				<input id="lname" name="lname" class="text required" type="text" value="<?php echo $_SESSION['UA_DETAILS']['lname']; ?>" />
			</li>
            <li>
				<label for="profile"><span class="required">Profile Details</span></label>
				<textarea class="text" maxlength="200"  name="profile" id="profile" ><?php echo $_SESSION['UA_DETAILS']['profile']; ?></textarea>
			</li>
            <li>
				<label for="dob"><span class="required">Date Of Birth</span></label>
				<input id="dob" name="dob" class="required"  type="text" value="<?php echo $_SESSION['UA_DETAILS']['dob']; ?>" />
			</li>
            <li>
				<label for="gender"><span class="required">Gender</span></label>
				<span><input type="radio" name="gender" class="required" value="m" <?php if($_SESSION['UA_DETAILS']['gender']=='m'){ echo 'checked="checked"'; }?>/> Male</span>&nbsp;&nbsp;
                <span><input type="radio" name="gender" class="required" value="f" <?php if($_SESSION['UA_DETAILS']['gender']=='f'){ echo 'checked="checked"'; }?>/> Female</span> 
			</li>
            <li>
                <label for="modlgn_photo">Profile Photo</label>
            	<input type="file" name="photo" accept="gif|jpg|png" id="modlgn_photo" />
            </li>

		</ul>
	</fieldset>
  
  <?php } ?>
    <fieldset class="submit">
		<input type="submit" class="sbutton" value="Done" /> 
	</fieldset>
</form>
</div>