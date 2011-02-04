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
?><?php if($_GET['type']=='cat' && $_SESSION['UA_DETAILS']['level']=='admin'){ ?>
<div style="clear: both;"></div>
<div style="margin-top: 20px;">
<!-- Error Display Box Start  -->
<?php include('error.php'); ?>
<!-- Error Box End --></div>
 <div class="headDisp2">Activate Category :</div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="results">
	<thead>
		<tr>
			<th>No.</th>
			<th>Name</th>
            <th>Sub Categories</th>
			<th>Activate</th>
		</tr>
	</thead>
	<tbody>
    <?php 
            $results_arr = getCatRaw($db,$_SESSION['UA_DETAILS']['randid'],$_SESSION['UA_DETAILS']['level']);
            $id =0;
            foreach($results_arr as $value){
                $id++;
        ?>
		<tr>
			<td><?php echo $id; ?></td>
			<td><?php echo $value['cat']; ?></td>
            <td class="center"><input type="button" class="spbutton" value="Go"  onclick="window.location='<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=activate&type=subcat&id=<?php echo $value['id']; ?>'" /></td>
			<td class="center"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=activate&type=cat&subaction=actcat&id=<?php echo $value['id']; ?>"><img src="images/<?php if($value['active']) { echo "act";} else {echo "actd";} ?>.png" width="32px" height="32px" /></a></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>

		<tr>
			<th>No.</th>
			<th>Name</th>
            <th>Sub Categories</th>
			<th>Activate</th>
		</tr>
	</tfoot>
</table>
<div style="clear: both;margin-top: 80px;"></div>
<?php 
}elseif($_GET['type']=='subcat' && $_SESSION['UA_DETAILS']['level']=='admin' && !empty($_GET['id'])){ 
    $results_arr = getSubCatAdm($db,$_GET['id'],$_SESSION['UA_DETAILS']['level']);
    ?>
<div style="clear: both;"></div>
<div style="margin-top: 20px;">
<!-- Error Display Box Start  -->
<?php include('error.php'); ?>
<!-- Error Box End --></div>
 <div class="headDisp2">Activate Sub Categories of :<?php echo getCatWid($db,$_GET['id'],$_SESSION['UA_DETAILS']['level']); ?></div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="results">
	<thead>
		<tr>
			<th>No.</th>
			<th>Sub Category Name</th>
			<th>Activate</th>
		</tr>
	</thead>
	<tbody>
    <?php 
            
            $id =0;
            foreach($results_arr as $value){
                $id++;
        ?>
		<tr>
			<td><?php echo $id; ?></td>
			<td><?php echo $value['subcat']; ?></td>
			<td class="center"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=activate&type=subcat&subaction=actsubcat&id=<?php echo $value['id']; ?>"><img src="images/<?php if($value['active']) { echo "act";} else {echo "actd";} ?>.png" width="32px" height="32px" /></a></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>

		<tr>
			<th>No.</th>
			<th>Name</th>
			<th>Activate</th>
		</tr>
	</tfoot>
</table>
<div style="clear: both;margin-top: 80px;"></div>


<?php 
}elseif($_GET['type']=='qstn' && $_SESSION['UA_DETAILS']['level']=='admin'){ 
?>

<div style="clear: both;"></div>
<div style="margin-top: 20px;">
<!-- Error Display Box Start  -->
<?php include('error.php'); ?>
<!-- Error Box End --></div>
 <div class="headDisp2">Edit Questions :</div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="activateQstn">
	<thead>
		<tr>
			<th>No.</th>
			<th>Question</th>
			<th>Category</th>
            <th>Sub Category</th>
			<th>Activate</th>
		</tr>
	</thead>
	<tbody>
    <?php 
            $results_arr = getQstnList($db,$_SESSION['UA_DETAILS']);
            foreach($results_arr as $value){
        ?>
		<tr>
			<td>#<?php echo $value['qid']; ?></td>
			<td><?php echo strip_tags($value['question']); ?></td>
			<td><?php echo  $value['category']; ?></td>
            <td><?php echo  $value['sub_cat']; ?></td>
            <td class="center"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=getpage&page=activate&type=qstn&subaction=actqstn&qid=<?php echo $value['qid']; ?>"><img src="images/<?php if($value['active']) { echo "act";} else {echo "actd";} ?>.png" width="32px" height="32px" /></a></td>
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
<?php 
}
 ?>