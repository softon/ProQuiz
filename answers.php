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
if($_GET['action']!='answers' || empty($_GET['instid'])){
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
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.cookies.2.2.0.min.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
<script type="text/javascript">
    $('.headDisp').corner("5px");
    $('.divText div').corner("5px");
    $('.divData div').corner("5px");
    $('.listRows').corner('5px');
    $('.listCols').corner('5px');
    $('.pq_qtn').corner('5px');
    $('.pq_opt').corner('5px');
    $('.pq_opt_correct').corner('5px');
    $('.pq_opt_wrong').corner('5px');
    $('.pq_opt_urrgt').corner('5px');
    $('#headerResults').corner('bottom 25px');
</script>
<?php include_once('common_header.php'); ?>

</head>

<body>
<div id="wrapper">

	<div id="headerResults">Result <span>#<?php echo $_GET['instid']; ?></span></div>

	<!-- Menu Start  -->
    <div id="menu">
        <div class="corner-left"></div>
        <div id="menuCenterResults">
           <b>ProQuiz</b> Results
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
    <div style="clear: both;height: 10px;"></div>
    <div id="sideTop">
        <div class="corner-left"></div>
        <div id="sideTopCenter"></div>
        <div class="corner-Tright"></div>
    </div>
    <div class="sideCnt">
       <div class="sideData">
            <div class="sideDataType">Current Rank : <span class="sideDataValue"><?php echo $rank = Proquiz::getRank($db,$_SESSION['STATS']['DETAILS']['percentage'],$_SESSION['STATS']['DETAILS']['time_used']/$_SESSION['STATS']['DETAILS']['total_qstn']); ?></span></div>
       </div>
       <div class="sideData">
            <div class="sideDataType">Percentage : <span class="sideDataValue"><?php echo $_SESSION['STATS']['DETAILS']['percentage']; ?> %</span></div>
       </div>
       <div class="sideData">
            <div class="sideDataType">Current Percentile : <span class="sideDataValue"><?php  echo Proquiz::getPercentile($rank); ?></span></div>
       </div>
       <div class="sideData">
            <div class="sideDataType">Total Question : <span class="sideDataValue"><?php echo $_SESSION['STATS']['DETAILS']['total_qstn']; ?></span></div>
       </div>
       <div class="sideData">
            <div class="sideDataType">Total Correct Answers : <span class="sideDataValue"><?php echo $_SESSION['STATS']['DETAILS']['total_correct']; ?></span></div>
       </div>
       <div class="sideData">
            <div class="sideDataType">Total Time : <span class="sideDataValue"><?php echo $_SESSION['STATS']['DETAILS']['total_time']; ?> min</span></div>
       </div>
       <div class="sideData">
            <div class="sideDataType">Time Used : <span class="sideDataValue"><?php getTinMin($_SESSION['STATS']['DETAILS']['time_used']); ?> min</span></div>
       </div>
    </div>
    <div id="sideFooter">
        <div class="corner-bLeft"></div>
        <div id="sideBtmCenter"></div>
        <div class="corner-bRight"></div>
    </div>
            
</div>   <!-- sidebar End -->

	<div id="content">
		<div class="pqMain">
	    
     <div class="cntHolder">
      <!-- Results Display -->             
         <?php 
            foreach($_SESSION['STATS']['QID_DATA'] as $key=>$qid_data){
            
                getQuizRModule($qid_data,$_SESSION['STATS']['YOUR_ANS'][$key],$key);
                
            }
         
         ?>
      <!-- End Results -->
     </div>
		
		</div>
	</div>    <!-- content End -->

	<!-- Footer Include -->
    <div id="footer"><?php include_once('footer.php'); ?></div> <!-- wrraper End -->

</body>
</html>
