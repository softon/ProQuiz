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
<div style="clear: both;"></div>
<div style="margin-top: 20px;">
<!-- Error Display Box Start  -->
<?php include('error.php'); ?>
<!-- Error Box End --></div>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=cnt_mng&subaction=editcnt" method="post" id="cnt_form">
		
		<ul style="margin-top: 30px;">
            
			<li>
				<label for="ca_subject"><span class="required">Select Content :</span></label>
                <select id="cnt_name" name="cnt_name" class="text required">
                    <option value="" selected="selected" > -- </option>
                    <?php 
                        $cnt_val =  getCntList($db,'all');
                        foreach($cnt_val as $cnt){
                            echo '<option value="'.$cnt['name'].'">'.$cnt['name'].'</option>';
                        }
                    ?>
                </select>
			</li>
			<li>
				<textarea name="cnt_value" id="cnt_value" cols="30" rows="6" class="required"></textarea>
			</li>
		</ul>
	<fieldset class="submit">
		<input type="submit" class="sbutton" id="ca_submit" value="Submit"  />
	</fieldset>
	
	
</form>
</div>