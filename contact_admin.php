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
?><div id="container">
<div style="clear: both;"></div>
<div style="margin-top: 20px;">
<!-- Error Display Box Start  -->
<?php include('error.php'); ?>
<!-- Error Box End --></div>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=contact_admin&subaction=caadmin" method="post" id="ca_form">
		
		<ul style="margin-top: 30px;">
            
			<li>
				<label for="ca_subject"><span class="required">Subject</span></label>
				<input id="ca_subject" name="ca_subject" class="text required" type="text" />
			</li>
			<li>
				<label for="ca_message"><span class="required">Message</span></label>
				<textarea name="ca_message" cols="30" rows="6" class="required"></textarea>
			</li>
            <li>
                <p id="p-captcha">
            		<div id="captchaImg"><img id="captcha" src="captcha/securimage_show.php" alt="CAPTCHA Image" /></div>
                    <div id="captchaInput"><input type="text" name="captcha_code" size="16" maxlength="6" value="Enter Captcha" class="required" /></div>
                    <div id="captchaRefresh"><a href="#" onclick="document.getElementById('captcha').src = 'captcha/securimage_show.php?' + Math.random(); return false"><img title="Refresh Captcha Image" src="captcha/images/refresh.gif" /></a></div>
            	</p>
            </li>
		</ul>
	<fieldset class="submit">
		<input type="submit" class="sbutton" id="ca_submit" value="Submit"  />
	</fieldset>
	
	
</form>
</div>