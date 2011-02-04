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
$_SESSION['step'] = 1;
if($_GET['error']=='finish'){
    $_SESSION['ERROR'][0]['type'] = 'Done';
    $_SESSION['ERROR'][0]['reason'] = 'Process Completed.';
}elseif($_GET['error']=='error'){
    $_SESSION['ERROR'][0]['type'] = 'Error';
    $_SESSION['ERROR'][0]['reason'] = 'Some of the Process were Incomplete.|ProQuiz MayNot Function as Intended';
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
                    <li><a href="index.php" >STEP 1</a></li>
                    <li><a href="step2.php">STEP 2</a></li>
                    <li><a href="install.php">STEP 3</a></li>
                    <li><a href="finish.php" class="current">FINISH</a></li>
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
	    <div class="pqTitle"><a href="#">ProQuiz V2 Installed Successfully</a></div>
			<div class="pqSubTitle">Please read the Instructions Below.</div>
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
            <div class="headDisp">Congratulations:</div>
            <div class="listRows">Thank you for installing ProQuiz V2. We hope that you enjoy using our script
                                    .if any problem is found while the operation of the script the please report
                                     to the bug section so that our developer can find a solution as soon as posible.
                                    <ol style="margin: 5px 35px;">
                                        <li>Before Continuing Please Delete the install Directory for security reasons</li>
                                        <li>It is located at <a>"install/"</a> </li>
										<li>If at any point you want to start the reinstallation process then sinply restore the install
                                            directory and delete the <a>config.inc.php</a> file. This will restart the installations Process</li>
                                        <li>But be aware that all the data will be lost during re-installation.For any Queries Contact At<br />
                                            <strong><a href="mailto:proquiz@softon.org">proquiz@softon.org</a></strong></li>
                                    </ol>
            </div>
            <div class="headDisp">&nbsp;</div>
            <div class="pq_ft"> 
                <a href="../index.php" target="_self"><div id="pq_vres"  class="pq_btn">Done</div></a>
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