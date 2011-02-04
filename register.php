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
?><?php include_once('functions.php'); ?>
<?php 
    if(isset($_SESSION) && !empty($_SESSION['UA_DETAILS'])){
            header('Location:index.php');            
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo SITETITLE; ?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/login.css" />	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() { 
    
    $('#captcha_code').click(function(){
        $(this).attr('value','');
    });
    
    $('#dob').click(function(){
        $(this).attr('value','');
    });
    
    
    $('#register').validate({
        rules: {
                    password: {
        				required: true,
        				minlength: 5
        			},
        			cpassword: {
        				required: true,
        				minlength: 5,
        				equalTo: "#password"
        			},
                    email: {
        				required: true,
        				email: true,
        				remote: "functions.php"
        			},
                    username: {
        				required: true,
        				minlength: 4,
                        maxlength: 30,
        				remote: "functions.php"
        			}
                
                },
        messages: {
                   email: {
        				required: "Please enter a valid email address",
        				minlength: "Please enter a valid email address",
        				remote: jQuery.format("{0} is already in use")
        			}, 
                    username: {
        				remote: jQuery.format("{0} is already in use")
        			}
        }
        
    });
});
</script>
<?php include_once('common_header.php'); ?>
</head>

<body>

<div id="wrapper">

	<div id="header"><img src="images/banner.jpg" width="800px" width="154px" /></div>

		<!-- Menu Start  -->
    <div id="menu">
        <div class="corner-left"></div>
        <div id="menuCenter">
    	   <?php include_once('menu.php'); ?>
        </div>
        <div class="corner-right"></div>
  </div>    <!-- menu End -->

<!-- Start Sidebar -->
<div id="sidebar">
    <div class="sideCnt">
        <?php include_once('sidebar.php'); ?>
    </div>
    <div id="sideFooter">
        <div class="corner-bLeft"></div>
        <div id="sideBtmCenter"></div>
        <div class="corner-bRight"></div>
    </div>
</div>   <!-- sidebar End -->

	<div id="content">
		
		<div class="pqMain">
	    <div class="pqTitle"><a href="#">ProQuiz V2</a></div>
			<div class="pqSubTitle">Please Fill in The Details for a New Account...</div>
            <!-- Error Display Box Start  -->
                <?php include('error.php'); ?>
                <!-- Error Box End -->
        <div class="cntHolder">
            <div id="container">
              <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="register">
				<fieldset>
					<legend>Register </legend>
					<ul>
                        <li>
							<label for="fname"><span class="required">First Name</span></label>
							<input id="fname" name="fname" class="text required" type="text" value="<?php echo $_POST['fname']; ?>" />
						</li>
                        <li>
							<label for="lname"><span class="required">Last Name</span></label>
							<input id="lname" name="lname" class="text required" type="text" value="<?php echo $_POST['lname']; ?>" />
						</li>
						<li>
							<label for="email"><span class="required">Email address</span></label>
							<input id="email" name="email" type="text" value="<?php echo $_POST['email']; ?>" />
						</li>
						<li>
							<label for="username"><span class="required">Username</span></label>
							<input id="username" name="username"  type="text" value="<?php echo $_POST['username']; ?>" />
						</li>
						<li>
							<label for="password"><span class="required">Password</span></label>
							<input name="password" type="password"  id="password"  maxlength="20" />
						</li>
                        <li>
							<label for="cpassword"><span class="required">Confirm Password</span></label>
							<input name="cpassword" type="password"  id="cpassword" maxlength="20" />
						</li>
                        <li>
							<label for="profile"><span class="required">Profile Details(Optional)</span></label>
							<textarea   name="profile" maxlength="200" id="profile" ><?php echo $_POST['profile']; ?></textarea>
						</li>
                        <li>
							<label for="dob"><span class="required">Date Of Birth</span></label>
							<input id="dob" name="dob" class="required"  type="text" value="<?php $_POST['dob']?print($_POST['dob']):print("DD-MM-YYYY"); ?>" />
						</li>
                        <li>
							<label for="gender"><span class="required">Gender</span></label>
							<span><input type="radio" name="gender" class="required" value="m"/> Male</span>&nbsp;&nbsp;
                            <span><input type="radio" name="gender" class="required" value="f"/> Female</span> 
						</li>
                        <li>
                            <label for="modlgn_photo">Profile Photo(Optional)</label>
                        	<input type="file" accept="gif|jpg|png" name="photo" id="modlgn_photo" />
                        </li>
                        <li>
                            <p id="p-captcha">
                        		<div id="captchaImg"><img id="captcha" src="captcha/securimage_show.php" alt="CAPTCHA Image" /></div>
                                <div id="captchaInput"><input type="text" id="captcha_code" name="captcha_code" size="16" maxlength="6" value="Enter Captcha" /></div>
                                <div id="captchaRefresh"><a href="#" onclick="document.getElementById('captcha').src = 'captcha/securimage_show.php?' + Math.random(); return false"><img title="Refresh Captcha Image" src="captcha/images/refresh.gif" /></a></div>
                        	</p>
                        </li>
						
					</ul>
				</fieldset>
					<input type="hidden" name="action" value="register" />
				<fieldset class="submit">
					<input type="submit" class="sbutton" value="Register" /> &nbsp; <input type="reset" class="sbutton" value="Reset" />
				</fieldset>
				
				
			</form>
           </div>
        
        </div>   <!-- content holder    -->
			
		</div>
	</div>    <!-- content End -->

	<!-- Footer Include -->
    <div id="footer"><?php include_once('footer.php'); ?></div> <!-- wrraper End -->

</body>
</html>