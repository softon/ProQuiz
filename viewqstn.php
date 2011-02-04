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
?><div style="clear: both;"></div>
<div style="margin-top: 20px;">
<!-- Error Display Box Start  -->
<?php include('error.php'); ?>
<!-- Error Box End --></div>
 <div class="headDisp2">Edit Questions :</div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="results">
	<thead>
		<tr>
			<th>Qstn. ID</th>
			<th>Question</th>
			<th>Category</th>
            <th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
    <?php 
            $results_arr = getQstnList($db,$_SESSION['UA_DETAILS']);
            foreach($results_arr as $value){
        ?>
		<tr>
			<td>#<a href="#" target="_blank"><?php echo $value['qid']; ?></a></td>
			<td><?php echo strip_tags($value['question']); ?></td>
			<td><?php echo  $value['category']."-".$value['sub_cat']; ?></td>
			<td class="center"><input type="button" class="spbutton" value="Go"  onclick="window.location='<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=editqstn&type=mcq&qid=<?php echo $value['qid']; ?>'" /></td>
			<td class="center"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=viewqstn&subaction=delqstn&qid=<?php echo $value['qid']; ?>"><img src="images/wrongB.png" width="32px" height="32px" /></a></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>

		<tr>
			<th>Qstn. ID</th>
			<th>Question</th>
			<th>Category</th>
            <th>Edit</th>
			<th>Delete</th>

		</tr>
	</tfoot>
</table>
<div style="clear: both;margin-top: 80px;"></div>