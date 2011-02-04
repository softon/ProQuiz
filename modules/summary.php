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
?><div class="pqMain">
	    <div class="pqTitle"><a href="#">Quiz Summary</a></div>
			<div class="pqSubTitle">A copy of your Result has been stored in our records for future reference.For Viewing your results in future you can go to the &quot;<b>My Panel</b>&quot; Tab</div>
        <div class="cntHolder">
            <div class="headDisp">Position :</div>
                <div class="divText">
                    <div id="rankText">Rank</div>
                    <div id="perageText">Percentage</div>
                    <div id="perileText">Percentile</div>
                </div>
                <div style="clear: both;"></div>
                <div class="divData">
                    <div id="rankData"><?php echo $_SESSION['RESULTS']['rank']; ?></div>
                    <div id="perageData"><?php echo $_SESSION['RESULTS']['percentage']; ?>%</div>
                    <div id="perileData"><?php echo $_SESSION['RESULTS']['percentile']; ?>%</div>
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
            <div class="pq_ft2"> 
                <a href="answers.php?action=answers&instid=<?php echo $_SESSION['RESULTS']['instid']; ?>" target="_blank"><div id="pq_vres"  class="pq_btn">View Answers</div></a>
                <a href="quiz_menu.php" target="_self"><div id="pq_next"  class="pq_btn">New Quiz</div></a>
                <a href="my_account.php?action=getpage&page=results&type=all" target="_blank"><div id="pq_next"  class="pq_btn">Results Sheet</div></a>
            </div>
        </div>
			
		</div>