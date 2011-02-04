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
if(empty($_SESSION['UA_DETAILS'])){
    header('Location:login.php?error=take_quiz');
}elseif(getSettings($db,'gquiz')!='1'){
    if(getSettParam($db,'gquiz')!='installed'){
        header('Location:quiz_menu.php?error=quiz_notinstalled');    
    }else{
        header('Location:quiz_menu.php?error=quiz_disabled');
    }
    
}elseif(getSettParam($db,'gquiz')!='installed'){
        header('Location:quiz_menu.php?error=quiz_notinstalled');    
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
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>

<script type="text/javascript">
    $('.headDisp').corner("5px");
    $('.divText div').corner("5px");
    $('.divData div').corner("5px");
    $('.listRows').corner('5px');
    $('.listCols').corner('5px');
</script>

<script type="text/javascript">
jQuery(document).ready(function() {
    $('#quiz_setup').validate();
});
</script>
<link rel="stylesheet" href="css/timer_dark.css" media="screen" type="text/css" />
	<!--[if IE 7]>
	<link href="css/ie7fix.css" rel="stylesheet" type="text/css" />
	<![endif]-->

	<script src="js/jquery.lwtCountdown-1.0.js" type="text/javascript"></script>
    <?php if(!empty($_SESSION['PQ_QUIZ']) || !empty($_SESSION['RESULTS'])){ ?>
    <script src="js/quiz.js" type="text/javascript"></script>
    <?php } ?>
<?php include_once('common_header.php'); ?>
</head>

<body>
	<?php 
    if(!empty($_SESSION['PQ_QUIZ'])){
        include_once('timer.php');   
    }
     ?>
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
        <div id="sideBtmCenter"><span>&rarr; SHOW / HIDE &larr;</span></div>
        <div class="corner-bRight"></div>
    </div>
            
</div>   <!-- sidebar End -->

	<div id="content">
		<!-- Start Final Summary -->
        <?php
            if(empty($_SESSION['PQ_QUIZ']) && !empty($_SESSION['RESULTS'])){
                include_once('modules/summary.php');
            }else{
        ?>
        <!-- End Summary -->
		<div class="pqMain">
	    
        <div class="cntHolder">
        
        <?php  if(!empty($_SESSION['PQ_QUIZ'])){ ?>
            <div class="start_quiz_hld"></div>
        <?php } ?>
            <div class="pagination">
                <?php 
                    if(!empty($_SESSION['PQ_QUIZ'])){
                        include_once('modules/pagination.php'); 
                    }
                ?>
            </div>
        <!-- Setup Start  -->
            <?php 
            if(empty($_SESSION['PQ_QUIZ']) && empty($_SESSION['RESULTS'])){
                include('modules/setup.php');                 
            } ?>
        <!-- Setup End  -->
        <style>
            form li {
                float: none;
            }
        </style>
        <form name="pq_quiz_form" id="pq_quiz_form" action="<?php $_SERVER['PHP_SELF']; ?>?action=process_quiz" method="post" >
        <?php
        
            if(!empty($_SESSION['PQ_QUIZ'])){
                foreach($_SESSION['PQ_QUIZ']['DATA'] as $key=>$value){
                    getQuizModule($value,$key+1);
                    
                }
            }
        ?>
        
        
        
        
            <!-- Footer Buttons -->
            <?php 
            if(!empty($_SESSION['PQ_QUIZ'])){
                include('modules/buttons.php'); 
            } ?>
            <!-- End Footer Buttons  -->
            
             <div id="pq_answer">
                <input type="hidden" name="current_qstn" id="current_qstn" value="" />
                <input type="hidden" name="total_qstn" id="total_qstn" value="" />
             </div>
        </form>
        </div>
		
		</div>
        <?php } // summary else statment ends ?>
	</div>    <!-- content End -->

	<!-- Footer Include -->
    <div id="footer"><?php include_once('footer.php'); ?></div> <!-- wrraper End -->

</body>
</html>