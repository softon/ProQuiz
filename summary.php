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
    if(empty($_GET['qid'])){
        header('Location:index.php');
    }else{
        getSummary($pq,$db,$_GET['qid']);
    }
    $_SESSION['RESULTS']['total_blank'] = $_SESSION['RESULTS']['total_qstn'] - $_SESSION['RESULTS']['total_correct'] - $_SESSION['RESULTS']['total_wrong'];
    $_SESSION['RESULTS']['time_unused'] = $_SESSION['RESULTS']['total_time']*60 - $_SESSION['RESULTS']['time_used'];
    $_SESSION['RESULTS']['total_question'] = $_SESSION['RESULTS']['total_qstn'];
    $_SESSION['RESULTS']['USER'] = getUserData($db,$_SESSION['RESULTS']['user']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo SITETITLE; ?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />	
<link rel="stylesheet" href="css/quiz.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
<!--[if IE]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
<script type="text/javascript">
    $('.headDisp').corner("5px");
    $('.divText div').corner("5px");
    $('.divData div').corner("5px");
    $('.listRows').corner('5px');
    $('.listCols').corner('5px');

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
                
        <div class="sideImg">
            <img src="<?php echo IMG_DIR.$_SESSION['RESULTS']['USER']['photo']; ?>"  height="70px" width="70px"/>
        </div>
        <div class="sideData">
            <div class="sideDataType">Name : <span class="sideDataValue"><?php echo $_SESSION['RESULTS']['USER']['fname']." ".$_SESSION['UA_DETAILS']['lname']; ?></span></div>
        </div>
        <div class="sideData">
            <div class="sideDataType">Username : <span class="sideDataValue"><?php echo $_SESSION['RESULTS']['USER']['username']; ?></span></div>
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
	    <div class="pqTitle"><a href="#">Quiz Summary</a></div>
			<div class="pqSubTitle">Your Result is also been stored in our records.For Viewing your results afterwards you can go to the <b>My Account</b> Tab</div>
            <!-- Error Display Box Start  -->
                <?php include('error.php'); ?>
                <!-- Error Box End -->
        <div class="cntHolder">
            <div class="headDisp">Position :</div>
                <div class="divText">
                    <div id="rankText">Rank</div>
                    <div id="perageText">Percentage</div>
                    <div id="perileText">Percentile</div>
                </div>
                <div style="clear: both;"></div>
                <div class="divData">
                    <div id="rankData"><?php echo $rank = $pq->getRank($db,$_SESSION['RESULTS']['percentage'],$_SESSION['RESULTS']['time_used']/$_SESSION['RESULTS']['total_question']); ?></div>
                    <div id="perageData"><?php echo $_SESSION['RESULTS']['percentage']; ?>%</div>
                    <div id="perileData"><?php echo $pq->getPercentile($rank); ?>%</div>
                </div>       
                <div style="clear: both;"></div>
            <div class="headDisp">Details :</div>
                <div class="listRows">Total Questions : 
                    <div class="listCols"><?php echo $_SESSION['RESULTS']['total_question']; ?></div>
                </div>
                <div class="listRows">Total Correct Answers : 
                    <div class="listCols"><?php echo $_SESSION['RESULTS']['total_correct']; ?></div>
                </div>
                <div class="listRows">Total Incorrect Answers :  
                    <div class="listCols"><?php echo $_SESSION['RESULTS']['total_wrong']; ?></div>
                </div>
                <div class="listRows">Total Unanswered : 
                    <div class="listCols"><?php echo $_SESSION['RESULTS']['total_blank']; ?></div>
                </div>
                <div class="listRows">Total Time : 
                    <div class="listCols"><?php echo $_SESSION['RESULTS']['total_time']; ?> min</div>
                </div>
                <div class="listRows">Total Time Unused : 
                    <div class="listCols"><?php echo getTinMin($_SESSION['RESULTS']['time_unused']); ?> min</div>
                </div>
                <div style="clear: both;"></div>
   <?php if($sock = @fsockopen("chart.apis.google.com",80,$error_num,$error_str,5)){ ?>
            <div class="headDisp">Timing Chart :</div>    
            <div id="chartline" style="height:250px;width:500px;float: left; ">
                    <img src="<?php echo getLineUrl(); ?>" />
                </div>
                <div id="chartpie" style="height:100px;width:250px;float: left; ">
                    <img src="<?php echo getPieUrl(); ?>" />
                </div>
                <div id="chartpie" style="height:100px;width:250px;float: left; ">
                    <img src="<?php echo getMeterUrl(); ?>" />
                </div>
                <div style="clear: both;"></div>
    <?php } ?>
            <div class="headDisp">&nbsp;</div>
            <div class="pq_ft"> 
                <a href="answers.php?action=answers&instid=<?php echo $_GET['qid']; ?>" target="_blank"><div id="pq_vres"  class="pq_btn">View Answers</div></a>
                <a href="quiz_menu.php" target="_blank"><div id="pq_next"  class="pq_btn">New Quiz</div></a>
                <a href="my_account.php?action=getpage&page=results&type=all" target="_blank"><div id="pq_next"  class="pq_btn">Results Sheet</div></a>
            </div>
        </div>
			
		</div>
	</div>    <!-- content End -->

	<!-- Footer Include -->
    <div id="footer"><?php include_once('footer.php'); ?></div> <!-- wrraper End -->

</body>
</html>