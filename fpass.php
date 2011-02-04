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
			<div class="pqSubTitle">Enter Your Email Address that you used for the Registration of Your Account.Your Password will be mailed to this Email ID....</div>
        <div class="cntHolder">
            <div id="container">
              <form action="functions.php?action=recoverpass" method="post" id="fpass">
				<fieldset>
					<legend>Recover </legend>
					<ul>
						<li>
							<label for="email"><span class="required">Email address</span></label>
							<input id="email" name="email" class="text required email" type="text" />
							<label for="email" class="error">This must be a valid email address</label>
						</li>
					</ul>
				</fieldset>
				
				<fieldset class="submit">
					<input type="submit" class="sbutton" value="Recover" /> &nbsp; <input type="button" class="sbutton" value="Back"  onclick="window.location='login.php'" />
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