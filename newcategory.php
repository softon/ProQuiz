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
  <form action="<?php echo "functions.php?action=addcat"; ?>" method="post" id="profile_edit">
	<fieldset id="category">
		<legend>Category</legend>
		<ul>
            <li><div class="cat_ajax_status" id="cat_ajax_status" >Click Add to Add new Category / Edit to edit selected category</div></li>
			<li>
				<label for="category"><span class="required">Categories</span></label>
				<select name="category" id="cat_list">
                    <option value="" class="inactive" selected="selected" > -- </option>
                    <?php echo  getCatList($db,$_SESSION['UA_DETAILS']['randid'],$_SESSION['UA_DETAILS']['level']); ?>
                </select>
            </li>
            <li>
            <label ><span class="required">Select Action</span></label>
                <div class="spl_button">
                     <a id="cat_add" href="#Action">Add</a>
                </div>
                <div class="spl_button">
                     <a id="cat_edit" href="#Action">Edit</a>
                </div>
                <div class="spl_button">
                     <a id="cat_del" href="#Action">Del</a>
                </div>
			</li>
            <li class="cat_action">
				<label><span class="cat_action" class="required">Action</span></label>
                <input type="hidden" id="necat_input" name="necat_action" value="" />
				<input type="text" name="necat" value="" />
                <div class="spl_button">
                     <a id="cat_save" href="#Action">Save</a>
                </div>
                <div class="spl_button">
                     <a id="cat_cancel" href="#Action">Cancel</a>
                </div>
                
            </li>
        </ul>
	</fieldset>
    <fieldset id="subcat">
		<legend>Sub Category</legend>
		<ul>
            <li><div class="cat_ajax_status" id="sub_cat_ajax_status" >Click Add to Add new Sub Category / Edit to edit selected Sub Category</div></li>
			<li>
				<label for="subcategory"><span class="required">Sub-Categories</span></label>
				<select name="sub_category" id="sub_cat_list">
                    <option value="" class="inactive" selected="selected" > -- </option>
                </select>
            </li>
            <li>
            <label ><span class="required">Select Action</span></label>
                <div class="spl_button">
                     <a id="sub_cat_add" href="#Action">Add</a>
                </div>
                <div class="spl_button">
                     <a id="sub_cat_edit" href="#Action">Edit</a>
                </div>
                <div class="spl_button">
                     <a id="sub_cat_del" href="#Action">Del</a>
                </div>
			</li>
            <li class="sub_cat_action">
				<label><span class="sub_cat_action" class="required">Action</span></label>
                <input type="hidden" id="sub_necat_input" name="sub_necat_action" value="" />
				<input type="text" name="sub_necat" value="" />
                <div class="spl_button">
                     <a id="sub_cat_save" href="#Action">Save</a>
                </div>
                <div class="spl_button">
                     <a id="sub_cat_cancel" href="#Action">Cancel</a>
                </div>
                
            </li>
        </ul>
	</fieldset>
</form>
</div>