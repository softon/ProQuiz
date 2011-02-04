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
?><div id="container">
              <form action="<?php echo $_SERVER['PHP_SELF']."?action=pqsetup"; ?>" method="post" id="quiz_setup">
				<fieldset>
					<legend>Setup Quiz </legend>
					<ul>
						<li>
							<label for="t_question"><span class="required">Total Questions</span><span class="error" id="t_qstn_error"></span></label>
							<input id="t_question" name="t_question" class="digits required" type="text" />
						</li>
                        <li>
							<label for="t_time"><span class="required">Total Time (Min)</span></label>
							<input id="t_time" name="t_time" class="digits required" type="text" />
						</li>
                        <li>
							<label for="category"><span class="required">Category</span></label>
							<select style="min-width: 200px;height: 200px;" id="categorym" class="required" name="category[]" multiple="true">
                            <?php echo getCat_SubcatList($db); ?>
                            </select>
							<label for="category" class="error">Invalid Category.</label>
						</li>
					</ul>
				</fieldset>
				<input type="hidden" name="action" value="pqsetup" />
				<fieldset class="submit">
					<input type="submit" class="sbutton" value="Setup" /> &nbsp; <input type="button" class="sbutton" value="Cancel"  onclick="window.location='quiz_menu.php'" />
				</fieldset>
				
				
			</form>
           </div>