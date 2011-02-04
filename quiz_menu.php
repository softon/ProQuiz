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
if($_GET['error']=='loginsucss'){
    $_SESSION['ERROR']['type'] = 'Done';
    $_SESSION['ERROR']['reason'] = "Login Sucessfull.Please Select a Quiz Type to Take Quiz";
}elseif($_GET['error'] == 'quiz_disabled'){
    $_SESSION['ERROR']['type'] = 'Error';
    $_SESSION['ERROR']['reason'] = "Admin Has Blocked this type of Quiz for the Moment.|Please Refresh the page after some time and try again.";
}elseif($_GET['error'] == 'quiz_notinstalled'){
    $_SESSION['ERROR']['type'] = 'Error';
    $_SESSION['ERROR']['reason'] = "This Module is Not Installed.|Get ProQuiz Advanced Edition for this Module.";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo SITETITLE; ?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/jquery.tooltip.css" type="text/css" media="screen" />	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.tooltip.js"></script>
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
        <div id="sideBtmCenter"><span>&rarr; Show/Hide &larr;</span></div>
        <div class="corner-bRight"></div>
    </div>
<?php if(!empty($_SESSION['UA_DETAILS'])){ ?>
    <div style="clear: both;height: 10px;"></div>
    <div id="sideTop">
        <div class="corner-left"></div>
        <div id="sideTopCenter"><span><br />&rarr; Online Users &larr;</span></div>
        <div class="corner-Tright"></div>
    </div>
    <div class="sideCnt">
       <div class="sideData">
            <ul id="onlineUsersList">
                
            </ul>
       </div>
    </div>
    <div id="sideFooter">
        <div class="corner-bLeft"></div>
        <div id="sideBtmCenter"></div>
        <div class="corner-bRight"></div>
    </div>
<?php } ?>
</div>   <!-- sidebar End -->

	<div id="content">
		
		<div class="pqMain">
	    <div class="pqTitle"><a href="#">Quiz Menu</a></div>
			<div class="pqSubTitle">Select Quiz Type.</div>
            <!-- Error Display Box Start  -->
                <?php include('error.php'); ?>
                <!-- Error Box End -->
        <div class="cntHolder">
        <?php $modules_arr = getSettingsArr($db,'modules');
              foreach($modules_arr as $modulesf){
                $modulesf2 = explode("|",$modulesf['details']);
                if(!$modulesf['value']){
                    $suffix = "d";
                }else{
                    $suffix = "";
                }
        ?>
            <div class="iconBox<?php echo $suffix; ?>">
               <a title="<?php echo $modulesf2[0]." - ".$modulesf2[1]; ?>" href="<?php echo $modulesf['name'].".php"; ?>" target="_self"> <img src="images/icons/icon_<?php echo $modulesf['name'].$suffix; ?>.png" /><?php echo $modulesf2[0]; ?></a>
            </div>
        <?php } ?>
        </div>
			
		</div>
	</div>    <!-- content End -->

	<!-- Footer Include -->
    <div id="footer"><?php include_once('footer.php'); ?></div> <!-- wrraper End -->

</body>
</html>