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
?><?php if(file_exists('../config.inc.php')){
    die('<center>Install Script Disabled.</center>');
}
?>
<?php include_once('functions.php'); ?>
<?php
$_SESSION['step'] = 1;
if($_GET['error']=='nodirect'){
    $_SESSION['ERROR'][0]['type'] = 'Error';
    $_SESSION['ERROR'][0]['reason'] = 'You are not allowed to directly visit the page|Please read the terms and conditions.';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ProQuiz V2 - A Quiz Apart</title>
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />	
<script type="text/javascript" src="../js/jquery.js"></script>
<link href="../css/login.css" type="text/css" rel="stylesheet" media="screen" />
<link rel="stylesheet" href="../css/quiz.css" type="text/css" media="screen" />
<script type="text/javascript" src="../js/jquery.corner.js"></script>
<script type="text/javascript">
    $('.headDisp').corner("5px");
    $('.divText div').corner("5px");
    $('.divData div').corner("5px");
    $('.listRows').corner('5px');
    $('.listCols').corner('5px');

</script>
</head>

<body>

<div id="wrapper">

	<div id="header"><img src="../images/banner.jpg" width="800px" width="154px" /></div>

	<!-- Menu Start  -->
    <div id="menu">
        <div class="corner-left"></div>
        <div id="menuCenter">
    	   <div id="menuCenter">
    	       <ul>
                    <li><a href="index.php" class="current">STEP 1</a></li>
                    <li><a href="step2.php">STEP 2</a></li>
                    <li><a href="install.php">STEP 3</a></li>
                    <li><a href="finish.php">FINISH</a></li>
                </ul>       
            </div>
        </div>
        <div class="corner-right"></div>
  </div>    <!-- menu End -->

<!-- Start Sidebar -->
<div id="sidebar">
    <div id="sideFooter">
        <div class="corner-bLeft"></div>
        <div id="sideBtmCenter"></div>
        <div class="corner-bRight"></div>
    </div>
</div>   <!-- sidebar End -->

	<div id="content">
		
		<div class="pqMain">
	    <div class="pqTitle"><a href="#">ProQuiz V2 Install Script</a></div>
			<div class="pqSubTitle">Please Follow the Instructions to Finish the Installation.</div>
            <?php 
            if(!empty($_SESSION[ERROR])){
            foreach($_SESSION['ERROR'] as $value){ ?>
                    <div class="pqSub<?php echo $value['type']; ?>">
                        <ul>
                        <?php
                            $error_arr = explode('|',trim($value['reason'],'|'));
                            foreach($error_arr as $value_in){
                                echo  '<li>'.$value_in.'</li>';
                            }
                        ?>
                        </ul>
                    </div>
                    <div style="height: 5px;"></div>
                <?php }} ?>
        <div class="cntHolder">
            <div class="headDisp">Terms &amp; Conditions:</div>
            <div class="listRows">Welcome to ProQuiz V2 installation wizard.Please follow the instructions given 
                                    below carefully.Before starting with the installation make sure to get all the 
                                    required information like Database Username,Password,Server Address,Database Name
                                    ,etc.Here follows the Terms and Conditions of the Usage of the Script.
                                    <ol style="margin: 5px 35px;">
                                        <li>This Software is Licensed under GPL( GENERAL PUBLIC LICENSE)</li>
                                        <li>There is absolutely no guarantee about the Working of the project </li>
										<li>Under No circumstances you may remove our copyright from any of the 
                                            pages otherwise it will lead to damage to the functionality of the code.</li>
                                        <li>However if any problem is found towards to working or functionality then 
                                            we will be always happy to help you.Please contact us at<br />
                                            <strong><a href="mailto:proquiz@softon.org">proquiz@softon.org</a></strong></li>
                                    </ol>
            </div>
            <div class="headDisp">&nbsp;</div>
            <div class="pq_ft"> 
                <a href="http://www.softon.org/proquiz" target="_self"><div id="pq_next"  class="pq_btn">Cancel</div></a>
                <a href="step2.php?accept=yes" target="_self"><div id="pq_vres"  class="pq_btn">Accept</div></a>
            </div>
        </div>
			
		</div>
	</div>    <!-- content End -->

	<!-- Footer Include -->
    <div id="footer">
    <div class="corner-bLeft"></div>
	<div id="footer-valid">
		<span><div id="s">Powered by - <a href="http://www.softon.org">Softon Technologies</a></div></span>
	</div>
    <div class="corner-bRight"></div></div> <!-- wrraper End -->
<?php unset($_SESSION['ERROR']); ?>
</body>
</html>