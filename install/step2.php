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
if($_GET['accept']=='yes'){
    $_SESSION['step'] = 2;
    $_SESSION['TANDC'] = 'Accept';    
}

if($_SESSION['step']!=2 && $_SESSION['TANDC'] = 'Accept'){
    header('Location:index.php?error=nodirect');
}

if($_GET['error']=='invalid'){
    $_SESSION['ERROR'] = $_SESSION['VALID']['ERROR'];
}elseif($_GET['error']=='nodirect'){
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
                    <li><a href="index.php" >STEP 1</a></li>
                    <li><a href="step2.php" class="current">STEP 2</a></li>
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
	    <div class="pqTitle"><a href="#">ProQuiz V2 Install Script : STEP 2</a></div>
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
   <form action="install.php" method="post" id="installDetails">
        <div class="cntHolder">
            <div class="headDisp">MYSQL DATABASE INFO:</div>
                <div class="listRows">Database SERVER :  
                    <div class="listCols"><input type="text" name="db_server" class="required" /></div>
                </div>
                <div class="listRows">Database Username :  
                    <div class="listCols"><input type="text" name="db_user" class="required" /></div>
                </div>
                <div class="listRows">Database Password :  
                    <div class="listCols"><input type="password" name="db_pass" class="required" /></div>
                </div>
                <div class="listRows">Database Name :  
                    <div class="listCols"><input type="text" name="db_name"  class="required" /></div>
                </div>
                <div class="listRows">Table Prefix :  
                    <div class="listCols"><input type="text" name="db_prefix" /></div>
                </div>
            <div class="headDisp">SITE SETTINGS:</div>
                <div class="listRows">Site Name :  
                    <div class="listCols"><input type="text" name="site_name" class="required" value="Your Site Name" /></div>
                </div>
                <div class="listRows">Site Title:  
                    <div class="listCols"><input type="text" name="site_title" class="required" value="ProQuiz V2 - A Quiz Apart" /></div>
                </div>
                <div class="listRows">Site Link :  
                    <div class="listCols"><input type="text" name="site_link" class="required" value="http://softon.org" /></div>
                </div>
            <div class="headDisp">Emails:</div>
                <div class="listRows">Enable Email Reports :  
                    <div class="listCols"><input type="checkbox" name="mail_enable" value="1" /></div>
                </div>
                <div class="listRows">Enable SMTP<br />(Only Gmail Account) :  
                    <div class="listCols"><input type="checkbox" name="mail_smtp" value="1" /></div>
                </div>
                <div class="listRows">Gmail/Gapps Username :  
                    <div class="listCols"><input type="text" name="mail_user" /></div>
                </div>
                <div class="listRows">Password :  
                    <div class="listCols"><input type="password" name="mail_pass" /></div>
                </div>
            <div class="headDisp">Admin Account:</div>
                <div class="listRows">Admin Email :  
                    <div class="listCols"><input type="text" name="admin_email" value="" class="required" /></div>
                </div>
                <div class="listRows">Admin Username :  
                    <div class="listCols"><input type="text" name="admin_user" value="admin" class="required" /></div>
                </div>
                <div class="listRows">Admin Password :  
                    <div class="listCols"><input type="password" name="admin_pass"   class="required" /></div>
                </div>
            <div class="headDisp">Sample Questions:</div>
                <div class="listRows">Enter Sample Questions:  
                    <div class="listCols"><input type="checkbox" name="sample_qstn" value="yes" /></div>
                </div>  
            <div class="headDisp">&nbsp;</div>
            <div class="pq_ft"> 
                <input type="hidden" name="step" value="install" />
                <input type="reset" class="sbutton" value="Clear" />
                <input type="submit" class="sbutton" value="Submit" />
            </div>
        </div>
	</form>		
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