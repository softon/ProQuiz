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
if(empty($_SESSION['UA_DETAILS']) || $_SESSION['UA_DETAILS']['level']!= 'admin'){
    header('Location:login.php');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo SITETITLE; ?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/login.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/quiz.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/table.css" type="text/css" media="screen" />
<link href="css/dropdown.css" media="screen" rel="stylesheet" type="text/css" />		
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
<script type="text/javascript" src="js/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/mypanel.js"></script>
<!--[if lt IE 7]>
<script type="text/javascript" src="js/jquery.dropdown.js"></script>
<![endif]-->

<!-- / END -->
<script type="text/javascript">
    $('.opt_ta').corner('5px');
    $('.options_cnt_new').corner('5px');
    $('.sel_ans').corner('5px');
    $('.options_cnt').corner('5px');
    $('.spl_button').corner('5px');
    $('.errorDispCnt div').corner('5px top');
</script>
<script src="js/jquery.lwtCountdown-1.0.js" type="text/javascript"></script>
<?php include_once('common_header.php'); ?>
</head>

<body>
<div class="errorDispCnt"   ><div  id="errorDispDiv"><div></div></div></div>
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
	    <?php include_once('adminmenu.php'); ?>
            <div class="cntHolder">

                 <?php
                        ////////////////////////////////////////////////////////////////
                        /*********************  Get Page ******************************/
                        if($_GET['action']=='getpage' && !empty($_GET['page'])){
                            @include_once($_GET['page'].'.php');   
                        }else{
                            echo getContents($db,'admin_panel');
                        }
                 ?>
                
            </div>
		
		</div>
 
	</div>    <!-- content End -->

	<!-- Footer Include -->
    <div id="footer"><?php include_once('footer.php'); ?></div> <!-- wrraper End -->

</body>
</html>