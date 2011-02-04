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
    
    if($_GET['error']=='complete'){
        $_SESSION['ERROR']['type'] = 'Done';
        $_SESSION['ERROR']['reason'] = "Operation Completed Sucessfully.Please Login to Continue";
    }elseif($_GET['error']=='accdone'){
        $_SESSION['ERROR']['type'] = 'Done';
        $_SESSION['ERROR']['reason'] = "New Account Created Sucessfully.Please Login to Continue";
    }elseif($_GET['error']=='logindeact'){
        $_SESSION['ERROR']['type'] = 'Error';
        $_SESSION['ERROR']['reason'] = "Your Account has been Deactivated by the admin.|It may be due to your mis-usage of the system";
    }elseif($_GET['error']=='fpassdone'){
        $_SESSION['ERROR']['type'] = 'Done';
        $_SESSION['ERROR']['reason'] = "Your Password has been  Successfully Reset,Please Check Your Email.";
    }elseif($_GET['error']=='noemail'){
        $_SESSION['ERROR']['type'] = 'Error';
        $_SESSION['ERROR']['reason'] = "No Such Email Found in the Database.Please Try Again";
    }elseif($_GET['error']=='fpasserror'){
        $_SESSION['ERROR']['type'] = 'Error';
        $_SESSION['ERROR']['reason'] = "Something Wrong with the System .Not Possible to Recover Your Password|Try Again Later.";
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
			<div class="pqSubTitle">Please Login to Continue...</div>
                <!-- Error Display Box Start  -->
                <?php include('error.php'); ?>
                <!-- Error Box End -->
        <div class="cntHolder">
            <div id="container">
              <form action="functions.php" method="post" id="login">
				<fieldset>
					<legend>Login </legend>
					<ul>
						<li>
							<label for="username"><span class="required">Username</span></label>
							<input id="username" name="username" class="text required" type="text" />
							<label for="username" class="error">This field cannot be empty</label>
						</li>
						
						<li>
							<label for="password"><span class="required">Password</span></label>
							<input name="password" type="password" class="text required" id="password" maxlength="20" />
						</li>
                        <?php if($_SESSION['LCNT']>=4){  ?>
                        <li>
                            <p id="p-captcha">
                        		<div id="captchaImg"><img id="captcha" src="captcha/securimage_show.php" alt="CAPTCHA Image" /></div>
                                <div id="captchaInput"><input type="text" name="captcha_code" size="16" maxlength="6" value="Enter Captcha" /></div>
                                <div id="captchaRefresh"><a href="#" onclick="document.getElementById('captcha').src = 'captcha/securimage_show.php?' + Math.random(); return false"><img src="captcha/images/refresh.gif" /></a></div>
                        	</p>
                        </li>
                        <?php } ?>
						<li>
							<label class="centered info"><a id="forgotpassword" href="fpass.php">Forgot Your password...</a></label>
						</li>
					</ul>
				</fieldset>
				<input type="hidden" name="action" value="login" />
				<fieldset class="submit">
					<input type="submit" class="sbutton" value="Login" /> &nbsp; <input type="button" class="sbutton" value="Register"  onclick="window.location='register.php'" />
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