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
?>
<div id="mcq_newqstn" style="margin-top: 50px;">
<div class="headDisp2">Add New Question (MCQ)</div>
             <div id="errorAjaxDisp"><!-- Error Display Box Start  -->
                <?php include('error.php'); ?>
                <!-- Error Box End -->
             </div>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=newqstn&type=mcq&subaction=addqstn" method="post" id="newqstn_mcq">
	
    <fieldset>
		<legend>Category</legend>
		<ul>
			<li>
				<label for="quiz_category"><span class="required">Select Category</span></label>
				<select name="quiz_category" id="quiz_category" class="required">
                    <option value="" class="inactive" selected="selected" > -- </option>
                    <?php echo  getCatList($db,$_SESSION['UA_DETAILS']['randid'],$_SESSION['UA_DETAILS']['level']); ?>
                </select>
			</li>
            <li id="quiz_sub_category">
				<label for="quiz_sub_category"><span class="required">Select Sub Category</span></label>
				<select name="quiz_sub_category" id="quiz_sub_category" class="required">
                    <option value="mcq">None</option>
                </select>
			</li>

		</ul>
	</fieldset>
    <fieldset id="mcq_qstn_ta">
		<legend>Question</legend>
		<ul>
			<textarea id="pq_question" name="pq_qstn" ></textarea>
		</ul>
	</fieldset>
    <fieldset id="mcq_option_ta">
		<legend>Options</legend>
        <input type="hidden" name="opt_count" id="opt_count" value="4" />
		      <div id="options_cnt">
                    <div class="options_cnt" id="option_1">
                        <table>
                            <tr>
                                <td class="opt_input"><span>1</span></td>
                                <td class="opt_tarea"><textarea name="option_1" class="opt_ta"></textarea></td>
                            </tr>
                        </table>
                        
                    </div>
                    <div class="options_cnt" id="option_2">
                        <table>
                            <tr>
                                <td class="opt_input"><span>2</span></td>
                                <td class="opt_tarea"><textarea name="option_2" class="opt_ta"></textarea></td>
                            </tr>
                        </table>
                        
                    </div>
                    <div class="options_cnt" id="option_3">
                        <table>
                            <tr>
                                <td class="opt_input"><span>3</span></td>
                                <td class="opt_tarea"><textarea name="option_3" class="opt_ta"></textarea></td>
                            </tr>
                        </table>
                        
                    </div>
                    <div class="options_cnt" id="option_4">
                        <table>
                            <tr>
                                <td class="opt_input"><span>4</span></td>
                                <td class="opt_tarea"><textarea name="option_4" class="opt_ta"></textarea></td>
                            </tr>
                        </table>
                        
                    </div>
                </div>

            <div class="spl_button">
                     <a id="options_cnt_new" href="#Add">+ Add Options</a>
                </div>
                <div class="spl_button">
                     <a id="options_cnt_del" href="#Add">- Remove Options</a>
                </div>
	</fieldset>
    <fieldset id="mcq_ans_input">
		<legend>Answer</legend>
		
            <div class="ans_cnt">
                <div class="ans_col1">
                <table>
                    <tr id="ans_opt_1">
                        <td><span><input type="radio" name="opt_ans" value="1" /></span></td>
                        <td><input type="button" name="option_1" class="sbutton" value="Option 1" /></td>
                    </tr>
                    <tr id="ans_opt_2">
                        <td><span><input type="radio" name="opt_ans" value="2"   /></span></td>
                        <td><input type="button" name="option_2" class="sbutton" value="Option 2" /></td>
                    </tr>
                    <tr id="ans_opt_3">
                        <td><span><input type="radio" name="opt_ans" value="3"   /></span></td>
                        <td><input type="button" name="option_3" class="sbutton" value="Option 3" /></td>
                    </tr>
                    <tr id="ans_opt_4">
                        <td><span><input type="radio" name="opt_ans" value="4"   /></span></td>
                        <td><input type="button" name="option_4" class="sbutton" value="Option 4" /></td>
                    </tr>
                </table>
                </div>
                
                <div class="ans_col2">
                    <div class="sel_ans">Your Answer</div>
                    <input name="correct_ans" id="correct_ans" class="required" type="hidden" value="" />
                </div>
            </div>
	</fieldset>
    <fieldset id="mcq_oq_flag">
		<legend>Open Quiz</legend>
		<ul>
			<li>
				<label for="open_quiz"><span class="required">Allow this question to be displayed for other users</span></label>
				<input type="checkbox" name="open_quiz" value="1" checked="checked" /> Yes
			</li>

		</ul>
	</fieldset>
	<fieldset class="submit" id="new_qstn_submit">
		<input type="submit" class="sbutton" value="Done" />
	</fieldset>
	
	
</form>
</div>