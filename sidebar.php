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
?><?php
// If User Logged In
    if(isset($_SESSION) && !empty($_SESSION['UA_DETAILS']) && $_GET['action']!='answers' && $_GET['action']!='slideshow') {
?>
<div class="sideImg">
    <img src="<?php echo IMG_DIR.$_SESSION['UA_DETAILS']['photo']; ?>"  height="70px" width="70px"/>
</div>
<div class="sideData">
    <div class="sideDataType">Name : <span class="sideDataValue"><?php echo $_SESSION['UA_DETAILS']['fname']." ".$_SESSION['UA_DETAILS']['lname']; ?></span></div>
</div>
<div id="side_ua_cnt">
<div class="sideData">
    <div class="sideDataType">Email Address : <span class="sideDataValue"><?php echo $_SESSION['UA_DETAILS']['email']; ?></span></div>
</div>
<div class="sideData">
    <div class="sideDataType">Date Of Birth : <span class="sideDataValue"><?php echo $_SESSION['UA_DETAILS']['dob']; ?></span></div>
</div>
<div class="sideData">
    <div class="sideDataType">Username : <span class="sideDataValue"><?php echo $_SESSION['UA_DETAILS']['username']; ?></span></div>
</div>
<div class="sideData">
    <div class="sideDataType">Profile Info : <span class="sideDataValue"><?php echo $_SESSION['UA_DETAILS']['profile']; ?></span></div>
</div>
</div>
<div class="quizData">
    
</div>
<?php }elseif($_GET['action']=='answers' && !empty($_GET['instid']) ){ ?>
<div class="sideImg">
    <img src="<?php echo IMG_DIR.$_SESSION['STATS']['USER_DETAILS']['photo']; ?>"  height="70px" width="70px"/>
</div>
<div class="sideData">
    <div class="sideDataType">Name : <span class="sideDataValue"><?php echo $_SESSION['STATS']['USER_DETAILS']['fname']." ".$_SESSION['UA_DETAILS']['lname']; ?></span></div>
</div>
<div class="sideData">
    <div class="sideDataType">Username : <span class="sideDataValue"><?php echo $_SESSION['STATS']['USER_DETAILS']['username']; ?></span></div>
</div>

<?php }elseif($_GET['action']=='slideshow' && !empty($_GET['instid']) ){ ?>
<div class="sideImg">
    <img src="<?php echo "./images/smileys/bounce.gif"; ?>"  height="70px" width="70px"/>
</div>
<div class="sideData">
    <div style="text-align: center;" id="imgstatus" class="sideDataType">Welcome</div>
</div>

<?php }else{ ?>
<div id="rankScroller">
    <ul>
    <?php  
    $results_arr = $auth->getUsersList($db,$_SESSION['UA_DETAILS']);
    $no = 0;
    foreach($results_arr as $rankf=>$valresult){
        $no++;
        ?>
            <li>
            <span id="ratingScroll"><?php for($i=1;$i<=10;$i++){
                            if($i == $valresult['rating']){
                                echo '<input name="user_rating'.$no.'" type="radio" class="star {split:2}" checked="checked" disabled="disabled"/>';   
                            }else{
                                echo '<input name="user_rating'.$no.'" type="radio" class="star {split:2}" disabled="disabled"/>';
                            }
                        }                
                ?></span>
                <span class="userDisp"><?php echo $valresult['username']; ?></span></li>
		
<?php } ?>
	
    </ul>
</div>
<?php } ?>