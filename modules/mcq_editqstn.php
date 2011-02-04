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
     $qstnArr = getQstnDetails($db,$_GET['qid'],$_SESSION['UA_DETAILS']);
     
?>
<div id="mcq_newqstn" style="margin-top: 50px;">
<div class="headDisp2">Edit Question (MCQ) : #<?php echo $_GET['qid']; ?></div>
             <div id="errorAjaxDisp"><!-- Error Display Box Start  -->
                <?php include('error.php'); ?>
                <!-- Error Box End -->
             </div>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=editqstn&type=mcq&subaction=editqstn&qid=<?php echo $_GET['qid']; ?>" method="post">
	
    <fieldset>
		<legend>Category</legend>
		<ul>
			<li>
				<label for="quiz_category"><span class="required">Select Category</span></label>
				<select name="quiz_category" class="required">
                    <?php 
                        $catListRaw = getCatRaw($db,$_SESSION['UA_DETAILS']['randid'],$_SESSION['UA_DETAILS']['level']);
                        foreach($catListRaw as $catList){
                            if($catList['cat'] == $qstnArr['category']){
                                echo '<option value="'.$catList['cat'].'" class="active" selected="selected" >'.$catList['cat'].'</option>';
                            }else{
                                echo '<option value="'.$catList['cat'].'" class="inactive" >'.$catList['cat'].'</option>';
                            }
                                
                        } 
                    ?>
                </select>
			</li>
            <li>
				<label for="quiz_sub_category"><span class="required">Select Sub Category</span></label>
				<select name="quiz_sub_category" class="required">
                   <?php 
                        $subcatListRaw = getSubCatRaw($db,$qstnArr['category'],$_SESSION['UA_DETAILS']['randid'],$_SESSION['UA_DETAILS']['level']);
                        foreach($subcatListRaw as $subcatList){
                            if($catList['subcat'] == $qstnArr['sub_cat']){
                                echo '<option value="'.$subcatList['subcat'].'" class="active" selected="selected" >'.$subcatList['subcat'].'</option>';
                            }else{
                                echo '<option value="'.$subcatList['subcat'].'" class="inactive" >'.$subcatList['subcat'].'</option>';
                            }
                                
                        }  
                   ?>
                </select>
			</li>

		</ul>
	</fieldset>
    <fieldset>
		<legend>Question</legend>
		<ul>
			<textarea id="pq_question" name="pq_qstn" class="required"  ><?php echo htmlentities($qstnArr['question']); ?></textarea>
		</ul>
	</fieldset>
    <fieldset>
		<legend>Options</legend>
        <?php 
            $opt_arr = explode("|",$qstnArr['options']);
            $opt_count = count($opt_arr);
        ?>
        <input type="hidden" name="opt_count" id="opt_count" value="<?php echo $opt_count; ?>" />
		      <div id="options_cnt">
              <?php 
                    foreach($opt_arr as $opt_no=>$opt){
              ?>
                    <div class="options_cnt" id="option_<?php echo $opt_no+1; ?>">
                        <table>
                            <tr>
                                <td class="opt_input"><span><?php echo $opt_no+1; ?></span></td>
                                <td class="opt_tarea">
                                    <textarea name="option_<?php echo $opt_no+1; ?>" class="opt_ta"><?php echo htmlentities($opt); ?></textarea>
                                </td>
                            </tr>
                        </table>
                        
                    </div>
              <?php } ?>
                    
                </div>

            <div class="spl_button">
                     <a id="options_cnt_new" href="#Add">+ Add Options</a>
                </div>
                <div class="spl_button">
                     <a id="options_cnt_del" href="#Add">- Remove Options</a>
                </div>
	</fieldset>
    <fieldset>
		<legend>Answer</legend>
		
            <div class="ans_cnt">
                <div class="ans_col1">
                <table>
                    <?php 
                        foreach($opt_arr as $opt_no=>$opt){
                            if($opt == $qstnArr['answer']){
                                $sel = 'checked="checked"';
                            }else{
                                $sel = "";
                            }
                    ?>    
                    <tr id="ans_opt_<?php echo $opt_no+1; ?>">
                        <td><span><input type="radio" name="opt_ans"  <?php echo $sel; ?> value="<?php echo $opt_no+1; ?>" /></span></td>
                        <td><input type="button" name="option_<?php echo $opt_no+1; ?>" class="sbutton" value="Option <?php echo $opt_no+1; ?>" /></td>
                    </tr>
                    <?php } ?>
                </table>
                </div>
                
                <div class="ans_col2">
                    <div class="sel_ans"><?php echo $qstnArr['answer']; ?></div>
                    <input name="correct_ans" id="correct_ans" class="required" type="hidden" value="<?php echo $qstnArr['answer']; ?>" />
                </div>
            </div>
	</fieldset>
    <fieldset>
		<legend>Open Quiz</legend>
		<ul>
			<li>
				<label for="open_quiz"><span class="required">Allow this question to be displayed for other users</span></label>
				<input type="checkbox" name="open_quiz" value="1" <?php if($qstnArr['open_quiz']=='1') {echo 'checked="checked"';} ?> /> Yes
			</li>

		</ul>
	</fieldset>
	<fieldset class="submit">
		<input type="submit" class="sbutton" value="Done" />
	</fieldset>
	
	
</form>
</div>