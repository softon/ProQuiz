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
?><div id="newquiz" style="margin-top: 50px;">
  <form action="<?php echo $_SERVER['PHP_SELF'].'?action=getpage&page=settings&subaction=editsett'; ?>" enctype="multipart/form-data" method="post" id="settings">
  <?php
        $group_arr = getSettingsGroup($db);
        foreach($group_arr as $value){
  ?>
  <fieldset>
		<legend><?php echo $value['group']; ?></legend>
		<ul>
        <?php
            $sett_arr = getSettingsArr($db,$value['group']);
            foreach($sett_arr as $sett){
                if($sett['type'] == 'checkbox'){
                    if($sett['value']){
                        $check = 'checked="checked"';   
                    }else{
                        $check = "";
                    }
                    if($sett['param'] != 'installed'){
                        $disabled = ' disabled="disabled"';
                    }else{
                        $disabled = '';
                    }
                    $ansval = '1';
                }else{
                    $ansval = $sett['value'];
                }
        ?>
			<li>
				<label for="<?php echo $sett['name']; ?>"><span class="required"><?php echo $sett['details']; ?></span></label>
				<input id="<?php echo $sett['name']; ?>" <?php echo $check.$disabled; ?> name="<?php echo $sett['name']; ?>" type="<?php echo $sett['type']; ?>" value="<?php echo $ansval; ?>" />
			</li>
        <?php } ?>
		</ul>
	</fieldset>
  <?php } ?>
    <fieldset class="submit">
		<input type="submit" class="sbutton" value="Done..." /> 
	</fieldset>
</form>
</div>